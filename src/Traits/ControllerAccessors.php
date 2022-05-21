<?php

namespace Adminro\Traits;

use Adminro\Controllers\ControllerSettings;

trait ControllerAccessors
{
    public function controllerSettings(): ControllerSettings
    {
        return $this->controllerSettings;
    }

    public function formFields()
    {
        return $this->controllerSettings()->formFields();
    }
}
