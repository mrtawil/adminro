<?php

namespace Adminro\Controllers;

class FormFields
{
    protected $controllerSettings;
    protected $forms = [];
    protected $selects = [];
    protected $multi_selects = [];

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

    public function customizeValidated()
    {
        $customizedValidated = customizeValidated($this->controllerSettings()->request()->validated(), $this->forms());
        $this->controllerSettings()->request()->setValidated($customizedValidated);
    }
}
