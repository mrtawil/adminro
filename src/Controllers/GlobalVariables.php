<?php

namespace Adminro\Controllers;

class GlobalVariables
{
    protected $controllerSettings;
    protected $global_variables = [];

    public function __construct($controllerSettings)
    {
        $this->controllerSettings = $controllerSettings;
    }

    public function controllerSettings(): ControllerSettings
    {
        return $this->controllerSettings;
    }

    public function setGlobalVariables($global_variables)
    {
        $this->global_variables = $global_variables;
    }

    public function addGlobalVariable($key, $value)
    {
        $this->global_variables[$key] = $value;
    }

    public function globalVariables()
    {
        return $this->global_variables;
    }

    public function globalVariable($key, $default = null)
    {
        if (!isset($this->global_variables[$key])) {
            return $default;
        }

        return $this->global_variables[$key];
    }
}
