<?php

namespace Adminro\Traits;

use Adminro\Controllers\Actions;
use Adminro\Controllers\Authentication;
use Adminro\Controllers\ControllerSettings;
use Adminro\Controllers\DataTable;
use Adminro\Controllers\FormFields;
use Adminro\Controllers\GlobalVariables;
use Adminro\Controllers\Info;
use Adminro\Controllers\Model;
use Adminro\Controllers\Request;
use Adminro\Controllers\Route;
use Adminro\Controllers\Select;
use Adminro\Controllers\Service;
use Adminro\Controllers\Subheader;

trait ControllerAccessors
{
    public function controllerSettings(): ControllerSettings
    {
        return $this->controllerSettings;
    }

    public function auth(): Authentication
    {
        return $this->controllerSettings()->auth();
    }

    public function info(): Info
    {
        return $this->controllerSettings()->info();
    }

    public function subheader(): Subheader
    {
        return $this->controllerSettings()->subheader();
    }

    public function actions(): Actions
    {
        return $this->controllerSettings()->actions();
    }

    public function model(): Model
    {
        return $this->controllerSettings()->model();
    }

    public function formFields(): FormFields
    {
        return $this->controllerSettings()->formFields();
    }

    public function request(): Request
    {
        return $this->controllerSettings()->request();
    }

    public function route(): Route
    {
        return $this->controllerSettings()->route();
    }

    public function dataTable(): DataTable
    {
        return $this->controllerSettings()->dataTable();
    }

    public function select(): Select
    {
        return $this->controllerSettings()->select();
    }

    public function services(): Service
    {
        return $this->controllerSettings()->services();
    }

    public function globalVariables(): GlobalVariables
    {
        return $this->controllerSettings()->globalVariables();
    }

    public function item()
    {
        return $this->controllerSettings()->model()->model();
    }
}
