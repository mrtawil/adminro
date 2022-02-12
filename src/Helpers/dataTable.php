<?php

use Adminro\Controllers\ControllerSettings;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;

function prepareDataTableSQL(ControllerSettings $controllerSettings, $model)
{
    $columns = $controllerSettings->dataTable()->dataTable()->getColumns();
    $datatables = datatables()->of($model);

    $checkbox_column = collect($columns)->firstWhere('data', 'checkbox');
    $user_profile_full_name_column = collect($columns)->firstWhere('data', 'user.profile.full_name');
    $created_user_profile_full_name_column = collect($columns)->firstWhere('data', 'created_user.profile.full_name');
    $model_title_column = collect($columns)->firstWhere('data', 'model.title');

    $columnsDateRange = collect($columns)->filter(function ($column) {
        return count(explode('.', $column['data'])) == 1 && $column['type'] == 'date_range';
    });

    $columnsImage = collect($columns)->filter(function ($column) {
        return count(explode('.', $column['data'])) == 1 && $column['type'] == 'image';
    });

    $columnsImageIntent = collect($columns)->filter(function ($column) {
        return count(explode('.', $column['data'])) > 1 && $column['type'] == 'image';
    });

    foreach ($columnsImage as $columnImage) {
        $datatables->addColumn($columnImage['data'], function ($item) use ($columnImage) {
            if (!$item[$columnImage['data']]) {
                return null;
            }

            return getStorageUrl($item[$columnImage['data'] . '_path'], $item[$columnImage['data']]);
        });
    }

    foreach ($columnsImageIntent as $columnImageIntent) {
        $nameTable = explode('.', $columnImageIntent['name']);
        $datatables->addColumn($columnImageIntent['data'], function ($item) use ($nameTable) {
            if (!$item[$nameTable[0]][$nameTable[1]]) {
                return null;
            }

            return getStorageUrl($item[$nameTable[0]][$nameTable[1] . '_path'], $item[$nameTable[0]][$nameTable[1]]);
        });
    }

    foreach ($columnsDateRange as $columnDateRange) {
        $datatables->addColumn($columnDateRange['data'], function ($item) use ($controllerSettings) {
            return view('adminro::includes.dashboard.datatables.columns.created_at', ['controllerSettings' => $controllerSettings, 'item' => $item]);
        });

        $datatables->filterColumn($columnDateRange['data'], function ($query, $keyword) use ($columnDateRange) {
            $date_range_table = explode('/', $keyword);
            $start_date = Carbon::parse($date_range_table[0])->startOfDay();
            $end_date = Carbon::parse($date_range_table[1])->endOfDay();

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

    if ($user_profile_full_name_column) {
        $datatables->addColumn('user.profile.full_name', function ($item) use ($controllerSettings) {
            return view('adminro::includes.dashboard.datatables.columns.user', ['controllerSettings' => $controllerSettings, 'item' => $item]);
        });

        $datatables->filterColumn('user.profile.full_name', function ($query, $keyword) {
            $query->whereHas('user.profile', function ($query) use ($keyword) {
                $query->where(DB::raw('CONCAT_WS(" ", first_name, last_name)'), 'like', "%$keyword%");
            });
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
    $init_complete_callback = strip_tags(file_get_contents(adminroViewsPath() . '\includes\dashboard\datatables\callbacks\init_complete.blade.php'));
    $draw_callback = strip_tags(file_get_contents(adminroViewsPath() . '\includes\dashboard\datatables\callbacks\draw.blade.php'));

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
    if (intVal(getDataTableRequestParam('status', $request)) == 4) {
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
