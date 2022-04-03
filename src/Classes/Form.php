<?php

namespace Adminro\Classes;

class Form
{
    protected $type;
    protected $required_create;
    protected $required_edit;
    protected $readonly_create;
    protected $readonly_edit;
    protected $disabled_create;
    protected $disabled_edit;
    protected $value_create;
    protected $column = 12;
    protected $width = '100%';
    protected $name;
    protected $placeholder;
    protected $additional = '';
    protected $error = 'error';
    protected $max_length = 191;
    protected $max_value;
    protected $min_value;
    protected $step = '1';
    protected $hidden_value = false;
    protected $multiple = false;
    protected $main;
    protected $data_type;
    protected $class_name = '';
    protected $permission = null;
    protected $sizes = [];
    protected $autocomplete = 'off';
    protected $blade_path;
    protected $script_path;

    public function __construct($attributes = [])
    {
        if (isset($attributes['type'])) $this->setType($attributes['type']);
        if (isset($attributes['required_create'])) $this->setRequiredCreate($attributes['required_create']);
        if (isset($attributes['required_edit'])) $this->setRequiredEdit($attributes['required_edit']);
        if (isset($attributes['readonly_create'])) $this->setReadOnlyCreate($attributes['readonly_create']);
        if (isset($attributes['readonly_edit'])) $this->setRequiredOnlyEdit($attributes['readonly_edit']);
        if (isset($attributes['disabled_create'])) $this->setDisabledCreate($attributes['disabled_create']);
        if (isset($attributes['disabled_edit'])) $this->setDisabledEdit($attributes['disabled_edit']);
        if (isset($attributes['value_create'])) $this->setValueCreate($attributes['value_create']);
        if (isset($attributes['column'])) $this->setColumn($attributes['column']);
        if (isset($attributes['name'])) $this->setName($attributes['name']);
        if (isset($attributes['placeholder'])) $this->setPlaceholder($attributes['placeholder']);
        if (isset($attributes['additional'])) $this->setAdditional($attributes['additional']);
        if (isset($attributes['max_length'])) $this->setMaxLength($attributes['max_length']);
        if (isset($attributes['max_value'])) $this->setMaxValue($attributes['max_value']);
        if (isset($attributes['min_value'])) $this->setMinValue($attributes['min_value']);
        if (isset($attributes['step'])) $this->setStep($attributes['step']);
        if (isset($attributes['hidden_value'])) $this->hiddenValue($attributes['hidden_value']);
        if (isset($attributes['multiple'])) $this->setMultiple($attributes['multiple']);
        if (isset($attributes['main'])) $this->setMain($attributes['main']);
        if (isset($attributes['data_type'])) $this->setDataType($attributes['data_type']);
        if (isset($attributes['class_name'])) $this->setClassName($attributes['class_name']);
        if (isset($attributes['permission'])) $this->setPermission($attributes['permission']);
        if (isset($attributes['sizes'])) $this->setSizes($attributes['sizes']);
        if (isset($attributes['autocomplete'])) $this->setAutocomplete($attributes['autocomplete']);
        if (isset($attributes['blade_path'])) $this->setAutocomplete($attributes['blade_path']);
        if (isset($attributes['script_path'])) $this->setAutocomplete($attributes['script_path']);
    }

    static public function make($type = null, $name = null, $required_both = null, $attributes = [])
    {
        if ($type !== null) {
            $attributes['type'] = $type;
        }

        if ($name !== null) {
            $attributes['name'] = $name;

            if (!isset($attributes['placeholder'])) {
                $attributes['placeholder'] = $name;
            }
        }

        if ($required_both !== null) {
            $attributes['required_create'] = $required_both;
            $attributes['required_edit'] = $required_both;
        }

        return new static($attributes);
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function setRequiredCreate($required_create)
    {
        $this->required_create = $required_create;

        return $this;
    }

    public function setRequiredEdit($required_edit)
    {
        $this->required_edit = $required_edit;

        return $this;
    }

    public function setReadOnlyCreate($readonly_create)
    {
        $this->readonly_create = $readonly_create;

        return $this;
    }

    public function setRequiredOnlyEdit($readonly_edit)
    {
        $this->readonly_edit = $readonly_edit;

        return $this;
    }

    public function setDisabledCreate($disabled_create)
    {
        $this->disabled_create = $disabled_create;

        return $this;
    }

    public function setDisabledEdit($disabled_edit)
    {
        $this->disabled_edit = $disabled_edit;

        return $this;
    }

    public function setValueCreate($value_create)
    {
        $this->value_create = $value_create;

        return $this;
    }

    public function setColumn($column)
    {
        $this->column = $column;

        return $this;
    }

    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    public function setAdditional($additional)
    {
        $this->additional = $additional;

        return $this;
    }

    public function setError($error)
    {
        $this->error = $error;

        return $this;
    }

    public function setMaxLength($max_length)
    {
        $this->max_length = $max_length;

        return $this;
    }

    public function setMaxValue($max_value)
    {
        $this->max_value = $max_value;

        return $this;
    }

    public function setMinValue($min_value)
    {
        $this->min_value = $min_value;

        return $this;
    }

    public function setStep($step)
    {
        $this->step = $step;

        return $this;
    }

    public function setHiddenValue($hidden_value)
    {
        $this->hidden_value = $hidden_value;

        return $this;
    }

    public function setMultiple($multiple)
    {
        $this->multiple = $multiple;

        return $this;
    }

    public function setMain($main)
    {
        $this->main = $main;

        return $this;
    }

    public function setDataType($data_type)
    {
        $this->data_type = $data_type;

        return $this;
    }

    public function setClassName($class_name)
    {
        $this->class_name = $class_name;

        return $this;
    }

    public function setPermission($permission)
    {
        $this->permission = $permission;

        return $this;
    }

    public function setSizes($sizes)
    {
        $this->sizes = $sizes;

        return $this;
    }

    public function setAutocomplete($autocomplete)
    {
        $this->autocomplete = $autocomplete;

        return $this;
    }

    public function setBladePath($blade_path)
    {
        $this->blade_path = $blade_path;

        return $this;
    }

    public function setScriptPath($script_path)
    {
        $this->script_path = $script_path;

        return $this;
    }

    public function type()
    {
        return $this->type;
    }

    public function requiredCreate()
    {
        return $this->required_create;
    }

    public function requiredEdit()
    {
        return $this->required_edit;
    }

    public function readOnlyCreate()
    {
        return $this->readonly_create;
    }

    public function readOnlyEdit()
    {
        return $this->readonly_edit;
    }

    public function disabledCreate()
    {
        return $this->disabled_create;
    }

    public function disabledEdit()
    {
        return $this->disabled_edit;
    }

    public function valueCreate()
    {
        return $this->value_create;
    }

    public function column()
    {
        return $this->column;
    }

    public function width()
    {
        return $this->width;
    }

    public function name()
    {
        return $this->name;
    }

    public function placeholder()
    {
        return $this->placeholder;
    }

    public function additional()
    {
        return $this->additional;
    }

    public function error()
    {
        return $this->error;
    }

    public function maxLength()
    {
        return $this->max_length;
    }

    public function maxValue()
    {
        return $this->max_value;
    }

    public function minValue()
    {
        return $this->min_value;
    }

    public function step()
    {
        return $this->step;
    }

    public function hiddenValue()
    {
        return $this->hidden_value;
    }

    public function multiple()
    {
        return $this->multiple;
    }

    public function main()
    {
        return $this->main;
    }

    public function dataType()
    {
        return $this->data_type;
    }

    public function className()
    {
        return $this->class_name;
    }

    public function permission()
    {
        return $this->permission;
    }

    public function sizes()
    {
        return $this->sizes;
    }

    public function autocomplete()
    {
        return $this->autocomplete;
    }

    public function bladePath()
    {
        return $this->blade_path;
    }

    public function scriptPath()
    {
        return $this->script_path;
    }

    public function attributes()
    {
        $attributes = [
            'type' => $this->type(),
            'required_create' => $this->requiredCreate(),
            'required_edit' => $this->requiredEdit(),
            'readonly_create' => $this->readOnlyCreate(),
            'readonly_edit' => $this->readOnlyEdit(),
            'disabled_create' => $this->disabledCreate(),
            'disabled_edit' => $this->disabledEdit(),
            'value_create' => $this->valueCreate(),
            'column' => $this->column(),
            'name' => $this->name(),
            'placeholder' => $this->placeholder(),
            'additional' => $this->additional(),
            'max_length' => $this->maxLength(),
            'max_value' => $this->maxValue(),
            'min_value' => $this->minValue(),
            'step' => $this->step(),
            'hidden_value' => $this->hiddenValue(),
            'multiple' => $this->multiple(),
            'main' => $this->main(),
            'data_type' => $this->dataType(),
            'class_name' => $this->className(),
            'permission' => $this->permission(),
            'sizes' => $this->sizes(),
            'autocomplete' => $this->autocomplete(),
            'blade_path' => $this->bladePath(),
            'script_path' => $this->scriptPath(),
        ];

        return $attributes;
    }
}
