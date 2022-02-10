<?php

namespace Adminro\Controllers;

class FormFields
{
    protected $controllerSettings;
    protected $forms = [];
    protected $selects = [];
    protected $multi_selects = [];
    protected $table_selects = [];
    protected $model_selects = [];
    protected $dynamic_selects = [];

    public function __construct($controllerSettings)
    {
        $this->controllerSettings = $controllerSettings;
    }

    public function controllerSettings(): ControllerSettings
    {
        return $this->controllerSettings;
    }

    public function setForms($forms)
    {
        $this->forms = $forms;
    }

    public function addSelect($key, $select)
    {
        $this->selects[$key] = $select;
    }

    public function addMultiSelect($key, $multi_select)
    {
        $this->multi_selects[$key] = $multi_select;
    }

    public function addTableSelect($key, $table_select)
    {
        $this->table_selects[$key] = $table_select;
    }

    public function addModelSelect($key, $model_select)
    {
        $this->model_selects[$key] = $model_select;
    }

    public function addDynamicSelect($key, $dynamic_select)
    {
        $this->dynamic_selects[$key] = $dynamic_select;
    }

    public function forms($main = true, $only_attributes = false)
    {
        $forms = collect($this->forms);

        $forms = $forms->filter(function ($form) use ($main) {
            if ($form->main() !== $main) {
                return null;
            }

            return true;
        });

        if ($only_attributes) {
            $forms = $forms->map(function ($form) {
                return $form->attributes();
            });
        }

        return $forms;
    }

    public function form($key)
    {
        return $this->forms[$key] ?? null;
    }

    public function select($key)
    {
        if (!isset($this->selects[$key])) {
            return null;
        }

        return $this->selects[$key];
    }

    public function selects()
    {
        return $this->selects;
    }

    public function multiSelect($key)
    {
        if (!isset($this->multi_selects[$key])) {
            return null;
        }

        return $this->multi_selects[$key];
    }

    public function multiSelects()
    {
        return $this->multi_selects;
    }

    public function tableSelect($key)
    {
        if (!isset($this->table_selects[$key])) {
            return null;
        }

        return $this->table_selects[$key];
    }

    public function tableSelects()
    {
        return $this->table_selects;
    }

    public function modelSelect($key)
    {
        if (!isset($this->model_selects[$key])) {
            return null;
        }

        return $this->model_selects[$key];
    }

    public function modelSelects()
    {
        return $this->model_selects;
    }

    public function dynamicSelect($key)
    {
        if (!isset($this->dynamic_selects[$key])) {
            return null;
        }

        return $this->dynamic_selects[$key];
    }

    public function dynamicSelects()
    {
        return $this->dynamic_selects;
    }

    public function customizeValidated()
    {
        $customizedValidated = customizeValidated($this->controllerSettings()->request()->validated(), $this->forms());
        $this->controllerSettings()->request()->setValidated($customizedValidated);
    }
}
