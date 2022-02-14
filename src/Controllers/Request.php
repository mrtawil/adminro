<?php

namespace Adminro\Controllers;

use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Request
{
    protected $controllerSettings;
    protected $edit_mode = false;
    protected $request;
    protected $rules = [];
    protected $validation_classes = [];
    protected $validated = [];

    public function __construct($controllerSettings)
    {
        $this->controllerSettings = $controllerSettings;
    }

    public function controllerSettings(): ControllerSettings
    {
        return $this->controllerSettings;
    }

    public function setEditMode($edit_mode = true)
    {
        $this->edit_mode = $edit_mode;
    }

    public function setRequest($request)
    {
        $this->request = $request;
    }

    public function setRules($rules, $customize_rules = true)
    {
        if ($customize_rules) {
            $this->rules = customizeRules($rules, $this->controllerSettings()->model()->model());
            return;
        }

        $this->rules = $rules;
    }

    public function addRule($key, $rule, $customize_rule = true)
    {
        if (!isset($this->rules[$key])) {
            $this->rules[$key] = [];
        }

        if ($customize_rule) {
            array_push($this->rules[$key], ...customizeRules($rule, $this->controllerSettings()->model()->model()));
            return;
        }

        array_push($this->rules[$key], $rule);
    }

    public function setValidationClasses($validation_classes)
    {
        $this->validation_classes = $validation_classes;
    }

    public function addValidationClass($key, $rule)
    {
        if (!isset($this->validation_classes[$key])) {
            $this->validation_classes[$key] = [];
        }

        array_push($this->validation_classes[$key], $rule);
    }

    public function setValidated($validated)
    {
        $this->validated = $validated;
    }

    public function editMode()
    {
        return $this->edit_mode;
    }

    public function request()
    {
        return $this->request;
    }

    public function requestKey($key)
    {
        if (!isset($this->request[$key])) {
            return null;
        }

        return $this->request[$key];
    }

    public function rules()
    {
        return $this->rules;
    }

    public function validationClasses()
    {
        return $this->validation_classes;
    }

    public function validated()
    {
        return $this->validated;
    }

    public function validatedKey($key)
    {
        if (!isset($this->validated[$key])) {
            return null;
        }

        return $this->validated[$key];
    }

    public function addValidated($key, $value)
    {
        $this->validated[$key] = $value;
    }

    public function addFormFieldsRules()
    {
        $forms = $this->controllerSettings()->formFields()->forms();

        foreach ($forms as $key => $form) {
            if (($form->requiredCreate() && !$this->editMode()) || ($form->requiredEdit() && $this->editMode())) {
                $this->addRule($key, 'required');
            }

            if ($form->type() == 'multiselect') {
                $this->addRule($key, 'array');
            }

            if (($form->type() == 'image')) {
                $this->addRule($key, 'image');
            }

            if (($form->type() == 'video')) {
                $this->addRule($key, 'mimes:mp4,mov,ogg,qt');
            }

            if (($form->type() == 'file')) {
                $this->addRule($key, []);
            }

            if (!in_array($key, array_keys($this->rules()))) {
                $this->addRule($key, 'nullable');
            }
        }
    }

    public function validate()
    {
        $validator = Validator::make($this->request()->all(), $this->rules());

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->all());
        }

        $this->setValidated($validator->validated());
    }

    public function validateClasses()
    {
        try {
            foreach ($this->validationClasses() as $validation_class) {
                app($validation_class, ['controllerSettings' => $this->controllerSettings(), 'validated' => $this->validated(), 'model' => $this->controllerSettings()->model()->model()]);
            }
        } catch (Exception $e) {
            throw ValidationException::withMessages([$e->getMessage()]);
        }
    }

    public function addCreatorKeys()
    {
        $this->addValidated('company_id', $this->controllerSettings()->auth()->company()->id);
        $this->addValidated('created_user_id', $this->controllerSettings()->auth()->user()->id);
    }
}
