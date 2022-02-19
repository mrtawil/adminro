<?php

namespace Adminro\Controllers;

class Subheader
{
    protected $controllerSettings;
    protected $subheader_show;
    protected $subheader_title;
    protected $subheader_description;
    protected $subheader_show_action;

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

    public function setAction($subheader_show_action)
    {
        $this->subheader_show_action = $subheader_show_action;
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

    public function action()
    {
        return $this->subheader_show_action;
    }
}
