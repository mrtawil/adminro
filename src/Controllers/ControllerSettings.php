<?php

namespace Adminro\Controllers;

class ControllerSettings
{
    protected $auth;
    protected $info;
    protected $subheader;
    protected $actions;
    protected $model;
    protected $form_fields;
    protected $request;
    protected $route;
    protected $dataTable;
    protected $select;
    protected $services;
    protected $global_variables;

    public function __construct()
    {
        $this->auth = new Authentication(controllerSettings: $this);
        $this->info = new Info(controllerSettings: $this);
        $this->subheader = new Subheader(controllerSettings: $this);
        $this->actions = new Actions(controllerSettings: $this);
        $this->model = new Model(controllerSettings: $this);
        $this->form_fields = new FormFields(controllerSettings: $this);
        $this->request = new Request(controllerSettings: $this);
        $this->route = new Route(controllerSettings: $this);
        $this->dataTable = new DataTable(controllerSettings: $this);
        $this->select = new Select(controllerSettings: $this);
        $this->services = new Service(controllerSettings: $this);
        $this->global_variables = new GlobalVariables(controllerSettings: $this);
    }

    public function auth(): Authentication
    {
        return $this->auth;
    }

    public function info(): Info
    {
        return $this->info;
    }

    public function subheader(): Subheader
    {
        return $this->subheader;
    }

    public function actions(): Actions
    {
        return $this->actions;
    }

    public function model(): Model
    {
        return $this->model;
    }

    public function formFields(): FormFields
    {
        return $this->form_fields;
    }

    public function request(): Request
    {
        return $this->request;
    }

    public function route(): Route
    {
        return $this->route;
    }

    public function dataTable(): DataTable
    {
        return $this->dataTable;
    }

    public function select(): Select
    {
        return $this->select;
    }

    public function services(): Service
    {
        return $this->services;
    }

    public function globalVariables(): GlobalVariables
    {
        return $this->global_variables;
    }
}
