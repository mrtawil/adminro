<?php

use Carbon\Carbon;
use Adminro\Classes\Form;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\URL;

function setActiveDashboardAside($active_route)
{
    $dashboard = config('dashboard');
    $query_params = collect(request()->all())->keys();

    $active_parent = null;
    $active_item = null;

    foreach ($dashboard['aside']['sections'] as $section) {
        foreach ($section['parents'] as $parent) {
            if (isset($parent['other_routes']) && collect($parent['other_routes'])->contains($active_route)) {
                if (!$active_parent) $active_parent = $parent;
            }

            if (isset($parent['other_params'])) {
                foreach ($parent['other_params'] as $other_param) {
                    if (!$query_params->contains($other_param)) {
                        continue;
                    }

                    if (Arr::hasAny($parent['other_params'], $query_params)) {
                        if (!$active_parent) $active_parent = $parent;
                        break;
                    }
                }
            }

            $items = collect($parent['items']);
            if ($items->count() <= 0) {
                continue;
            }

            foreach ($items as $item) {
                if (isset($item['other_routes']) && collect($item['other_routes'])->contains($active_route)) {
                    if (!$active_parent) $active_parent = $parent;
                    if (!$active_item) $active_item = $item;
                    break;
                }

                if (isset($item['other_params'])) {
                    foreach ($item['other_params'] as $other_param) {
                        if (!$query_params->contains($other_param)) {
                            continue;
                        }

                        if (Arr::hasAny($item['other_params'], $query_params)) {
                            if (!$active_parent) $active_parent = $parent;
                            if (!$active_item) $active_item = $item;
                            break;
                        }
                    }
                }

                if ($item['href'] == $active_route) {
                    if (!$active_parent) $active_parent = $parent;
                    if (!$active_item) $active_item = $item;
                    break;
                }
            }
        }
    }

    config(['dashboard.checked' => true]);
    config(['dashboard.active_parent' => $active_parent]);
    config(['dashboard.active_item' => $active_item]);
}

function isCurrentUrl($active_route, $type, $id, $route = null)
{
    if (!config('dashboard.checked')) {
        setActiveDashboardAside($active_route);
    }

    if ($type == 'parent' && config('dashboard.active_parent.id')) {
        return config('dashboard.active_parent.id') == $id;
    }

    if ($type == 'item' && config('dashboard.active_item.id')) {
        return config('dashboard.active_item.id') == $id;
    }

    return $route == $active_route;
}

function appendArrayToObject($obj, $array)
{
    foreach ($array as $key => $value) {
        $obj->$key = $value;
    }

    return $obj;
}

function getMethodShortName($method)
{
    $path = explode('\\', $method);
    $path = explode('::', $method);
    return array_pop($path);
}

function array_swap($array, $oldPos, $newPos): array
{
    $array_keys = array_keys($array);
    [$array_keys[$oldPos], $array_keys[$newPos]] = [$array_keys[$newPos], $array_keys[$oldPos]];
    $arrayNew = [];
    foreach ($array_keys as $key) {
        $arrayNew[$key] = $array[$key];
    }
    return $arrayNew;
}

function capitalizeAttribute($array, $attribute)
{
    return $array->map(function ($item) use ($attribute) {
        $item[$attribute] = ucfirst($item[$attribute]);
        return $item;
    });
}

function getObjectAttribute($object, $attributes)
{
    $value = $object;
    $attributes_table = explode(".", $attributes);

    foreach ($attributes_table as $attribute) {
        $value = $value[$attribute] ?? null;
    }

    return $value;
}

function getRoute($href, $param): string
{
    return route($href, $param);
}

function getCompanyEmail($prefix, $website): string
{
    return $prefix . "@" . $website;
}

function getStorageUrl($path, $name, $size = null): string
{
    if ($size) {
        return URL::asset("storage/$path/$size/$name");
    } else {
        return URL::asset("storage/$path/$name");
    }
}

function isStringMatch($string, $value): bool
{
    return stristr($string, $value) !== false;
}

function emptyArray(int $int)
{
    return array_fill(0, $int, null);
}

function getDateString($date)
{
    return Carbon::parse($date)->format('Y-m-d');
}

function getDistanceBetweenTwoPoints($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $unit = "M") // Haversine
{
    $earthRadius = 6371000;
    $latFrom = deg2rad($latitudeFrom);
    $lonFrom = deg2rad($longitudeFrom);
    $latTo = deg2rad($latitudeTo);
    $lonTo = deg2rad($longitudeTo);

    $latDelta = $latTo - $latFrom;
    $lonDelta = $lonTo - $lonFrom;

    $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
        cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

    $result = $angle * $earthRadius;
    switch ($unit) {
        case "KM":
            $result = $result / 1000;
            break;
        case "M":
            break;
    }

    return $result;
}

function getFormName($key, $prefix = '', $suffix = '')
{
    $name = '';

    $name_words = explode('.', $prefix . $key . $suffix);
    foreach ($name_words as $key => $name_word) {
        if ($key === 0) {
            $name .= $name_word;
        } else {
            $name .= '[' . $name_word . ']';
        }
    }

    return $name;
}

function getFormId($key, $prefix = '', $suffix = '')
{
    $id = '';

    $id_words = explode('.', $prefix . $key . $suffix);
    foreach ($id_words as $key => $id_word) {
        if ($key === 0) {
            $id .= $id_word;
        } else {
            $id .= '-' . $id_word;
        }
    }

    return $id;
}

function getFormValue($key, $form, $model, $edit_mode, $prefix = '', $suffix = '', $translatable = '')
{
    if ($form instanceof Form) {
        $form = $form->attributes();
    }

    if ($form['hidden_value']) {
        return;
    }

    if ($translatable) {
        if (
            $model
            && method_exists($model, 'getTranslatableAttributes')
            && in_array($key, $model->getTranslatableAttributes())
        ) {
            $value = $model->getTranslation($key, $translatable, false);
        } else {
            $value = null;
        }
    } else {
        $value = $model[$key] ?? null;
    }

    if ($edit_mode) {
        switch ($form['type']) {
            case 'tagify':
                return implode(' ,', $value ?? []) ?? '';
                break;

            case 'date':
                if (!isset($value)) {
                    return null;
                }

                if ($value instanceof Carbon) {
                    return $value->toDateString();
                } else {
                    return Carbon::parse($value)->toDateString();
                }
                break;

            case 'map':
                if (!isset($value)) {
                    return '';
                }

                if (env('DB_CONNECTION') == 'mysql') {
                    if (isStringMatch($prefix . $key . $suffix, 'latitude')) return $value->getLat();
                    if (isStringMatch($prefix . $key . $suffix, 'longitute')) return $value->getLng();
                } else if (env('DB_CONNECTION') == 'mongodb') {
                    if (isStringMatch($prefix . $key . $suffix, 'latitude')) return $value['coordinates'][1];
                    if (isStringMatch($prefix . $key . $suffix, 'longitute')) return $value['coordinates'][0];
                }

            default:
                return $value;
                break;
        }
    }

    $old = old($key);
    if ($old) {
        if ($translatable) {
            return $old[$translatable] ?? "";
        }

        return $old;
    }

    return $form['value_create'];
}

function getFormRequired($form, $edit_mode)
{
    if ($form instanceof Form) {
        $form = $form->attributes();
    }

    if ($edit_mode && $form['required_edit']) {
        return true;
    }

    if (!$edit_mode && $form['required_create']) {
        return true;
    }

    return false;
}

function getFormReadOnly($form, $edit_mode)
{
    if ($form instanceof Form) {
        $form = $form->attributes();
    }

    if ($edit_mode && $form['readonly_edit']) {
        return true;
    }

    if (!$edit_mode && $form['readonly_create']) {
        return true;
    }

    return false;
}

function getFormDisabled($form, $edit_mode)
{
    if ($form instanceof Form) {
        $form = $form->attributes();
    }

    if ($edit_mode && $form['disabled_edit']) {
        return true;
    }

    if (!$edit_mode && $form['disabled_create']) {
        return true;
    }

    return false;
}

function getTranslatableLabelSuffix($translatable)
{
    if (!$translatable) {
        return '';
    }

    return '(' . $translatable . ')';
}


function getTranslatableKeySuffix($translatable)
{
    if (!$translatable) {
        return '';
    }

    return '[' . $translatable . ']';
}

function getLocalesFromClassName($className)
{
    if (!$className) {
        return [];
    }

    $locales = collect();
    $classes = collect(explode(' ', $className));

    $classes->each(function ($class) use ($locales) {
        if (isStringMatch($class, 'locale-')) {
            $locale = explode('locale-', $class)[1];
            $locales->push($locale);
        }
    });

    return $locales->toArray();
}
