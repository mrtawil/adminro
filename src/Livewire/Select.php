<?php

namespace Adminro\Livewire;

use Adminro\Controllers\ControllerSettings;
use Exception;
use Livewire\Component;

class Select extends Component
{
    public $key;
    public $form;
    public $model;
    public $edit_mode;
    public $select;
    public $select_cp;
    public $value = '';
    public $search = '';

    public function render()
    {
        return view('adminro::livewire.select');
    }

    public function mount(ControllerSettings $controllerSettings)
    {
        if (!$controllerSettings->formFields()->select($this->key)) {
            throw new Exception('Select form of [\'' . $this->key . '\'] is not found.');
        }

        $this->form = $this->form->attributes();
        $this->model = $controllerSettings->model()->model();
        $this->edit_mode = $controllerSettings->request()->editMode();
        $this->select = $controllerSettings->formFields()->select($this->key)->attributes();
        $this->select_cp = $this->select;

        foreach ($this->select['listeners'] as $listener) {
            $this->{$listener['key_listener']} = $listener['default'] ?? null;
        }

        if (!$this->form['hidden_value']) {
            $this->value = $this->select['items_selected'][0] ?? '';

            if (!$this->edit_mode && $this->value === null) {
                $this->value = $controllerSettings->request()->request()->old($this->key) ?? '';
            }
        }
    }

    protected function getListeners()
    {
        $listeners = collect();
        foreach ($this->select['listeners'] as $select_listener) {
            $listeners->put($select_listener['key_listener'] . '_changed', 'handleListenerFunctions');
        }

        return $listeners->toArray();
    }

    public function handleListenerFunctions($key, $value)
    {
        $listener = collect($this->select['listeners'])->firstWhere('key_listener', $key);
        if (!$listener) {
            return;
        }

        foreach ($listener['functions'] as $function) {
            if (!method_exists($this, $function)) {
                break;
            }

            $this->$function($key, $value);
        }
    }

    public function updated($name, $value)
    {
        $this->emit($this->key . '_changed', $this->key, $value);
    }

    public function onValueChange()
    {
        $this->rebuildSelect();
    }

    public function rebuildSelect()
    {
        $this->emitSelf($this->key . '_rebuild', ['key' => $this->key]);
    }

    public function storeProperty($key, $value)
    {
        $this->$key = $value;
    }

    public function resetValue()
    {
        $this->reset('value');
        $this->emit($this->key . '_changed', $this->key, null);
    }
}
