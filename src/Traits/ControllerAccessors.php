<?php

namespace Adminro\Traits;

use Adminro\Controllers\ControllerSettings;

trait ControllerAccessors
{
    public function controllerSettings(): ControllerSettings
    {
        return $this->controllerSettings;
    }

    public function info()
    {
        return $this->controllerSettings()->info();
    }

    public function formFields()
    {
        return $this->controllerSettings()->formFields();
    }

    public function item()
    {
        return $this->controllerSettings()->model()->model();
    }
}
