<?php

namespace Adminro\Services;

use Adminro\Traits\ApiService as TraitsApiService;
use Illuminate\Database\Eloquent\Collection;
use Exception;

class ApiService
{
    use TraitsApiService;

    protected $model;

    public static function make()
    {
        return new static();
    }

    public function formatModel($attributes = [], ...$models)
    {
        if (!$this->model) {
            throw new Exception('Please specify a model in the class');
        }

        $models_formatted = collect();
        foreach ($models as $model) {
            $model_formatted = formatModel($model, $this->model::formFields(), $attributes);
            $this->addOnFormatModel($attributes, $model, $model_formatted);
            $models_formatted->push($model_formatted);
        }

        if (!is_array($models) && !$models instanceof Collection) {
            return $models_formatted->first();
        }

        return $models_formatted;
    }
}
