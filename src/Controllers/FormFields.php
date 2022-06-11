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

    public function forms($main = true)
    {
        $forms = collect($this->forms);

        $forms = $forms->filter(function ($form) use ($main) {
            if ($form->main() !== $main) {
                return false;
            }

            if ($this->controllerSettings->auth()->user()) {
                if (!$this->controllerSettings->auth()->user()->can($form->permission())) {
                    return false;
                }
            }

            return true;
        });

        return $forms->toArray();
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

    public function attributes()
    {
        $forms = collect($this->forms())->map(function ($form) {
            return $form->attributes();
        });

        $selects = collect($this->selects())->map(function ($select) {
            return $select->attributes();
        });

        $multi_selects = collect($this->multiSelects())->map(function ($multi_select) {
            return $multi_select->attributes();
        });

        $attributes = [
            'forms' => $forms,
            'selects' => $selects,
            'multi_selects' => $multi_selects,
        ];

        return $attributes;
    }

    public function addConfigDefaults()
    {
        $config_forms = config('adminro.forms');
        foreach ($config_forms as $form_type => $forms) {
            foreach ($forms as $key => $form) {
                switch ($form_type) {
                    case 'select':
                        if ($this->controllerSettings()->model()->model()) {
                            $form->setItemsSelected($this->controllerSettings()->model()->model()->$key);
                        }

                        $this->addSelect($key, $form);
                        break;
                }
            }
        }
    }

    public function customizeValidated()
    {
        $customizedValidated = customizeValidated($this->controllerSettings()->request()->validated(), $this->forms());
        $this->controllerSettings()->request()->setValidated($customizedValidated);
    }
}
