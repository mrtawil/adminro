<?php

namespace Adminro\Controllers;

class Service
{
    protected $controllerSettings;
    protected $service_classes = [];
    protected $services = [];

    public function __construct($controllerSettings)
    {
        $this->controllerSettings = $controllerSettings;
    }

    public function controllerSettings(): ControllerSettings
    {
        return $this->controllerSettings;
    }

    public function setServiceClasses($service_classes)
    {
        $this->service_classes = $service_classes;
    }

    public function setService($service_class, $service)
    {
        $this->services[$service_class] = $service;
    }

    public function serviceClasses()
    {
        return $this->service_classes;
    }

    public function service($class)
    {
        if (!isset($this->services[$class])) {
            return null;
        }

        return $this->services[$class];
    }

    public function services()
    {
        return $this->services;
    }

    public function initServiceClasses()
    {
        foreach ($this->serviceClasses() as $service_class) {
            $this->setService($service_class, app($service_class, ['controllerSettings' => $this->controllerSettings()]));
        }
    }

    public function executeMethod($method)
    {
        foreach ($this->services() as $service) {
            if (method_exists($service, $method)) {
                $service->$method();
            }
        }
    }
}
