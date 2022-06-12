<?php

use Adminro\Constants\Constants;
use Adminro\Controllers\ControllerSettings;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;

function prepareDataTableSQL(ControllerSettings $controllerSettings, $model)
{
    $columns = $controllerSettings->dataTable()->dataTable()->getColumns();
    $datatables = datatables()->of($model);

    $checkbox_column = collect($columns)->firstWhere('data', 'checkbox');
    $created_user_profile_full_name_column = collect($columns)->firstWhere('data', 'created_user.profile.full_name');
    $status_column = collect($columns)->firstWhere('data', 'status');
    $model_title_column = collect($columns)->firstWhere('data', 'model.title');

    $columnsDate = collect($columns)->filter(function ($column) {
        return count(explode('.', $column['data'])) == 1 && $column['type'] == 'date';
    });

    $columnsDateRange = collect($columns)->filter(function ($column) {
        return count(explode('.', $column['data'])) == 1 && $column['type'] == 'date_range';
    });

    $columnsImage = collect($columns)->filter(function ($column) {
        return count(explode('.', $column['data'])) == 1 && $column['type'] == 'image';
    });

    $columnsImageIntent = collect($columns)->filter(function ($column) {
        return count(explode('.', $column['data'])) > 1 && $column['type'] == 'image';
    });

    $columnsLocaleStrings = collect($columns)->filter(function ($column) {
        return count(explode('.', $column['data'])) == 1 && $column['type'] == 'string' && $column['className'];
    });

    $columnsLocaleStringsIntent = collect($columns)->filter(function ($column) {
        return count(explode('.', $column['data'])) > 1 && $column['type'] == 'string' && $column['className'];
    });

    foreach ($columnsLocaleStrings as $columnLocaleStrings) {
        $locales = getLocalesFromClassName($columnLocaleStrings["className"]);
        if (count($locales) <= 0) {
            continue;
        }

        $datatables->addColumn($columnLocaleStrings['data'], function ($item) use ($columnLocaleStrings, $locales) {
            if (!$item[$columnLocaleStrings['data']]) {
                return null;
            }

            if (count($locales) > 0) {
                return $item->getTranslation($columnLocaleStrings['data'], $locales[0]);
            }

            return $item->{$columnLocaleStrings['data']};
        });


        $datatables->filterColumn($columnLocaleStrings['data'], function ($query, $keyword) use ($columnLocaleStrings, $locales) {
            $query->whereRaw("json_extract(LOWER(" . $columnLocaleStrings['data'] . "), \"$.$locales[0]\") LIKE convert(? using utf8mb4) collate utf8mb4_general_ci", ['%' . $keyword . '%']);
        });
    }

    foreach ($columnsLocaleStringsIntent as $columnLocaleStringsIntent) {
        $locales = getLocalesFromClassName($columnLocaleStringsIntent["className"]);
        if (count($locales) <= 0) {
            continue;
        }

        $nameTable = explode('.', $columnLocaleStringsIntent['name']);
        $datatables->addColumn($columnLocaleStringsIntent['data'], function ($item) use ($nameTable, $locales) {
            if (!$item[$nameTable[0]][$nameTable[1]]) {
                return null;
            }

            if (count($locales) > 0) {
                return $item->{$nameTable[0]}->getTranslation($nameTable[1], $locales[0]);
            }

            return $item->{$nameTable[0]}->{$nameTable[1]};
        });

        $datatables->filterColumn($columnLocaleStringsIntent['data'], function ($query, $keyword) use ($locales, $nameTable) {
            $query->whereHas($nameTable[0], function ($query) use ($locales, $nameTable, $keyword) {
                $query->where($nameTable[1] . '->' . $locales[0], 'like', '%' . $keyword . '%');
            });
        });
    }

    foreach ($columnsImage as $columnImage) {
        $datatables->addColumn($columnImage['data'], function ($item) use ($controllerSettings, $columnImage) {
            if (!$item[$columnImage['data']]) {
                return null;
            }

            return view('adminro::includes.dashboard.datatables.columns.image', ['controllerSettings' => $controllerSettings, 'item' => $item, 'image' => getStorageUrl($item[$columnImage['data'] . '_path'], $item[$columnImage['data']])]);
        });
    }

    foreach ($columnsImageIntent as $columnImageIntent) {
        $nameTable = explode('.', $columnImageIntent['name']);
        $datatables->addColumn($columnImageIntent['data'], function ($item) use ($controllerSettings, $nameTable) {
            if (!$item[$nameTable[0]][$nameTable[1]]) {
                return null;
            }

            return view('adminro::includes.dashboard.datatables.columns.image', ['controllerSettings' => $controllerSettings, 'item' => $item, 'image' => getStorageUrl($item[$nameTable[0]][$nameTable[1] . '_path'], $item[$nameTable[0]][$nameTable[1]])]);
        });
    }

    foreach ($columnsDate as $columnDate) {
        $datatables->addColumn($columnDate['data'], function ($item) use ($controllerSettings, $columnDate) {
            return view('adminro::includes.dashboard.datatables.columns.date', ['controllerSettings' => $controllerSettings, 'item' => $item, 'date' => $item[$columnDate['data']]]);
        });

        $datatables->filterColumn($columnDate['data'], function ($query, $keyword) use ($columnDate) {
            $date_table = explode('/', $keyword);
            $start_date = Carbon::parse($date_table[0])->startOfDay();
            $end_date = Carbon::parse($date_table[1])->endOfDay();

            $query->whereBetween($columnDate['data'], [$start_date, $end_date]);
        });

        $datatables->orderColumn($columnDate['data'], function ($query, $order) use ($columnDate) {
            $query->orderBy($columnDate['data'], $order);
        });
    }

    foreach ($columnsDateRange as $columnDateRange) {
        $datatables->addColumn($columnDateRange['data'], function ($item) use ($controllerSettings, $columnDateRange) {
            return view('adminro::includes.dashboard.datatables.columns.date_time', ['controllerSettings' => $controllerSettings, 'item' => $item, 'date' => $item[$columnDateRange['data']]]);
        });

        $datatables->filterColumn($columnDateRange['data'], function ($query, $keyword) use ($columnDateRange) {
            $date_table = explode('/', $keyword);
            $start_date = Carbon::parse($date_table[0])->startOfDay();
            $end_date = Carbon::parse($date_table[1])->endOfDay();

            $query->whereBetween($columnDateRange['data'], [$start_date, $end_date]);
        });

        $datatables->orderColumn($columnDateRange['data'], function ($query, $order) use ($columnDateRange) {
            $query->orderBy($columnDateRange['data'], $order);
        });
    }

    if ($checkbox_column) {
        $datatables->addColumn('checkbox', function ($item) use ($controllerSettings) {
            return view('adminro::includes.dashboard.datatables.columns.checkbox', ['controllerSettings' => $controllerSettings, 'item' => $item]);
        });
    }

    if ($created_user_profile_full_name_column) {
        $datatables->addColumn('created_user.profile.full_name', function ($item) use ($controllerSettings) {
            return view('adminro::includes.dashboard.datatables.columns.created_user', ['controllerSettings' => $controllerSettings, 'item' => $item]);
        });

        $datatables->filterColumn('createdUser.profile.full_name', function ($query, $keyword) {
            $query->whereHas('createdUser.profile', function ($query) use ($keyword) {
                $query->where(DB::raw('CONCAT_WS(" ", first_name, last_name)'), 'like', "%$keyword%");
            });
        });
    }


    if ($status_column) {
        $datatables->addColumn('status', function ($item) use ($controllerSettings) {
            return view('adminro::includes.dashboard.datatables.columns.status', ['controllerSettings' => $controllerSettings, 'item' => $item]);
        });

        $datatables->filterColumn('status', function ($query, $keyword) {
            $query->where('status', $keyword);
        });
    }

    if ($model_title_column) {
        $datatables->filterColumn('model.title', function ($query, $keyword) {
            $query->whereHas('model', function ($query) use ($keyword) {
                $query->where('title', 'LIKE', "%$keyword%");
            });
        });
    }

    $datatables->addColumn('actions', function ($item) use ($controllerSettings) {
        return view('adminro::includes.dashboard.datatables.columns.actions', ['controllerSettings' => $controllerSettings, 'item' => $item]);
    });

    return $datatables;
}

function prepareDataTableHTML($datatables, $columns)
{
    $init_complete_callback = strip_tags(file_get_contents(__DIR__ . '/../resources/views/includes/dashboard/datatables/callbacks/init_complete.blade.php'));
    $draw_callback = strip_tags(file_get_contents(__DIR__ . '/../resources/views/includes/dashboard/datatables/callbacks/draw.blade.php'));

    return $datatables->builder()
        ->setTableId('datatable-html')
        ->columns($columns)
        ->minifiedAjax()
        ->orderBy(1)
        ->responsive()
        ->buttons(
            Button::make('export')->addClass('d-none'),
            Button::make('print')->addClass('d-none'),
            Button::make('copy')->addClass('d-none'),
            Button::make('reset')->addClass('d-none'),
            Button::make('colvis')->text('Filter'),
        )
        ->dom("
            <'row'<'col-md-12 d-flex justify-content-between align-items-center bulk-action-container'l>>
            <'row'<'col-sm-12'tr>>
            <'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6 d-flex aling-item-center justify-content-center justify-content-md-end mt-2 mt-md-0'p>>
        ")
        ->lengthMenu(['5', '10', '25', '50', '100'])
        ->pageLength('10')
        ->languageLengthMenu('Display _MENU_')
        ->initComplete($init_complete_callback)
        ->drawCallback($draw_callback);
}

function prepareDataTableQuery($model, $request)
{
    if (intVal(getDataTableRequestParam('status', $request)) == Constants::STATUS_DELETED) {
        $model->onlyTrashed();
    }

    return $model;
}

function getDataTableRequestParam($data, $request)
{
    $columns = $request['columns'];

    $column = collect($columns)->firstWhere('data', $data);
    if (!$column) {
        return null;
    }

    if (!isset($column['search']['value'])) {
        return null;
    }

    return $column['search']['value'];
}
