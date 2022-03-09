<?php

namespace Adminro\Services;

use Illuminate\Database\Eloquent\Collection;

class ApiService
{
    protected $model;

    public static function make()
    {
        return new static();
    }

    public function formatModel($attributes = [], ...$models)
    {
        $models_formatted = collect();
        foreach ($models as $model) {
            $model_formatted = formatModel($model, $this->model::formFields(), $attributes);
            $models_formatted->push($model_formatted);
        }

        if (!is_array($models) && !$models instanceof Collection) {
            return $models_formatted->first();
        }

        return $models_formatted;
    }
}
