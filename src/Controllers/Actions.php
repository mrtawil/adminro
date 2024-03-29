<?php

namespace Adminro\Controllers;

class Actions
{
    protected $controllerSettings;
    protected $create = true;
    protected $edit = true;
    protected $update = true;
    protected $destroy = false;
    protected $show = false;
    protected $print = false;
    protected $restore = true;
    protected $force_delete = true;
    protected $search = true;
    protected $reset = true;
    protected $buttons = true;
    protected $bulk_action = true;
    protected $back = true;
    protected $exit = false;

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

    public function setDestroy($destroy)
    {
        $this->destroy = $destroy;
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

    public function setBulkAction($bulk_action)
    {
        $this->bulk_action = $bulk_action;
    }

    public function setBack($back)
    {
        $this->back = $back;
    }

    public function setExit($exit)
    {
        $this->exit = $exit;
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

    public function destroy()
    {
        return $this->destroy;
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

    public function bulkAction()
    {
        return $this->bulk_action;
    }

    public function back()
    {
        return $this->back;
    }

    public function exit()
    {
        return $this->exit;
    }
}
