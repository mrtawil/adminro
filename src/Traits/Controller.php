<?php

namespace Adminro\Traits;

use Adminro\Controllers\ControllerSettings;

trait Controller
{
    public function controllerSettings(): ControllerSettings
    {
        return $this->controllerSettings;
    }

    public function policyAuthorize()
    {
    }

    public function addOnConstruct()
    {
    }

    public function addOnAll()
    {
    }

    public function addOnIndex()
    {
    }

    public function addOnCreate()
    {
    }

    public function addOnStore()
    {
    }

    public function addOnEdit()
    {
    }

    public function addOnUpdate()
    {
    }

    public function addOnDestroy()
    {
    }

    public function addOnRestore()
    {
    }

    public function addOnForceDelete()
    {
    }

    public function addOnRemoveFile($attribute)
    {
    }

    public function addOnBulkAction()
    {
    }

    public function addOnBeforeStore()
    {
    }

    public function addOnBeforeUpdate()
    {
    }

    public function addOnBeforeDestroy()
    {
    }

    public function addOnBeforeRestore()
    {
    }

    public function addOnBeforeForceDelete()
    {
    }

    public function addOnBeforeRemoveFile()
    {
    }

    public function addOnBeforeBulkAction()
    {
    }
}
