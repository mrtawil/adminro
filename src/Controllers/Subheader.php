<?php

namespace Adminro\Controllers;

class Subheader
{
    protected $controllerSettings;
    protected $subheader_show;
    protected $subheader_title;
    protected $subheader_description;
    protected $subheader_show_back;
    protected $subheader_show_action;
    protected $subheader_action_update;
    protected $subheader_action_print;
    protected $subheader_action_create;
    protected $subheader_action_exit;
    protected $subheader_action_delete;

    public function __construct($controllerSettings)
    {
        $this->controllerSettings = $controllerSettings;
    }

    public function controllerSettings(): ControllerSettings
    {
        return $this->controllerSettings;
    }

    public function setShow($subheader_show)
    {
        $this->subheader_show = $subheader_show;
    }

    public function setTitle($subheader_title)
    {
        $this->subheader_title = $subheader_title;
    }

    public function setDescription($subheader_description)
    {
        $this->subheader_description = $subheader_description;
    }

    public function setBack($subheader_show_back)
    {
        $this->subheader_show_back = $subheader_show_back;
    }

    public function setAction($subheader_show_action)
    {
        $this->subheader_show_action = $subheader_show_action;
    }

    public function setActionUpdate($subheader_action_update)
    {
        $this->subheader_action_update = $subheader_action_update;
    }

    public function setActionPrint($subheader_action_print)
    {
        $this->subheader_action_print = $subheader_action_print;
    }

    public function setActionCreate($subheader_action_create)
    {
        $this->subheader_action_create = $subheader_action_create;
    }

    public function setActionExit($subheader_action_exit)
    {
        $this->subheader_action_exit = $subheader_action_exit;
    }

    public function setActionDelete($subheader_action_delete)
    {
        $this->subheader_action_delete = $subheader_action_delete;
    }

    public function show()
    {
        return $this->subheader_show;
    }

    public function backUrl()
    {
        return $this->subheader_back_url;
    }

    public function title($prefix = '', $suffix = '')
    {
        if ($this->subheader_title) {
            return $this->subheader_title;
        }

        $output = $this->controllerSettings()->info()->singularTitle();
        if ($prefix) $output = $prefix . $output;
        if ($suffix) $output = $output . $suffix;
        return $output;
    }

    public function description()
    {
        return $this->subheader_description;
    }

    public function back()
    {
        return $this->subheader_show_back;
    }

    public function action()
    {
        return $this->subheader_show_action;
    }

    public function actionUpdate()
    {
        return $this->subheader_action_update;
    }

    public function actionPrint()
    {
        return $this->subheader_action_print;
    }

    public function actionCreate()
    {
        return $this->subheader_action_create;
    }

    public function actionExit()
    {
        return $this->subheader_action_exit;
    }

    public function actionDelete()
    {
        return $this->subheader_action_delete;
    }
}
