<?php

namespace Adminro\Controllers;

class Actions
{
    protected $controllerSettings;
    protected $create = true;
    protected $edit = true;
    protected $update = true;
    protected $delete = true;
    protected $show = false;
    protected $print = false;
    protected $restore = true;
    protected $force_delete = true;
    protected $search = true;
    protected $reset = true;
    protected $buttons = true;

    public function __construct($controllerSettings)
    {
        $this->controllerSettings = $controllerSettings;
    }

    public function controllerSettings(): ControllerSettings
    {
        return $this->controllerSettings;
    }

    public function setCreate($create)
    {
        $this->create = $create;
    }

    public function setEdit($edit)
    {
        $this->edit = $edit;
    }

    public function setUpdate($update)
    {
        $this->update = $update;
    }

    public function setDelete($delete)
    {
        $this->delete = $delete;
    }

    public function setShow($show)
    {
        $this->show = $show;
    }

    public function setPrint($print)
    {
        $this->print = $print;
    }

    public function setRestore($restore)
    {
        $this->restore = $restore;
    }

    public function setForceDelete($force_delete)
    {
        $this->force_delete = $force_delete;
    }

    public function setSearch($search)
    {
        $this->search = $search;
    }

    public function setReset($reset)
    {
        $this->reset = $reset;
    }

    public function setButtons($buttons)
    {
        $this->buttons = $buttons;
    }

    public function create()
    {
        return $this->create;
    }

    public function edit()
    {
        return $this->edit;
    }

    public function update()
    {
        return $this->update;
    }

    public function delete()
    {
        return $this->delete;
    }

    public function show()
    {
        return $this->show;
    }

    public function print()
    {
        return $this->print;
    }

    public function restore()
    {
        return $this->restore;
    }

    public function forceDelete()
    {
        return $this->restore;
    }

    public function search()
    {
        return $this->search;
    }

    public function reset()
    {
        return $this->reset;
    }

    public function buttons()
    {
        return $this->buttons;
    }
}
