<?php

namespace Adminro\Traits;

use Adminro\Controllers\ControllerSettings;

trait ControllerAccessors
{
    public function controllerSettings(): ControllerSettings
    {
        return $this->controllerSettings;
    }

    public function auth()
    {
        return $this->controllerSettings()->auth();
    }

    public function info()
    {
        return $this->controllerSettings()->info();
    }

    public function subheader()
    {
        return $this->controllerSettings()->subheader();
    }

    public function actions()
    {
        return $this->controllerSettings()->actions();
    }

    public function model()
    {
        return $this->controllerSettings()->model();
    }

    public function formFields()
    {
        return $this->controllerSettings()->formFields();
    }

    public function request()
    {
        return $this->controllerSettings()->request();
    }

    public function route()
    {
        return $this->controllerSettings()->route();
    }

    public function dataTable()
    {
        return $this->controllerSettings()->dataTable();
    }

    public function select()
    {
        return $this->controllerSettings()->select();
    }

    public function services()
    {
        return $this->controllerSettings()->services();
    }

    public function globalVariables()
    {
        return $this->controllerSettings()->globalVariables();
    }

    public function item()
    {
        return $this->controllerSettings()->model()->model();
    }
}
