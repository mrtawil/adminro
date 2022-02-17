<?php

namespace Adminro\Livewire;

use Adminro\Controllers\ControllerSettings;
use Adminro\Traits\FileLivewire;
use Livewire\Component;

class Image extends Component
{
    use FileLivewire;

    public $key;
    public $form;
    public $model;
    public $edit_mode;

    public function render()
    {
        return view('adminro::livewire.image');
    }

    public function mount(ControllerSettings $controllerSettings)
    {
        $this->form = $this->form->attributes();
        $this->model = $controllerSettings->model()->model();
        $this->edit_mode = $controllerSettings->request()->editMode();
    }
}
