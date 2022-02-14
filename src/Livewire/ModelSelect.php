<?php

namespace Adminro\Livewire;

use Adminro\Classes\Select;
use Adminro\Controllers\ControllerSettings;
use Adminro\Traits\SelectLivewire;
use Livewire\Component;

class ModelSelect extends Component
{
    use SelectLivewire;

    public $key;
    public $form;
    public $model;
    public $edit_mode;
    public $model_select_type;
    public $model_select_id;
    public $model_select_type_cp;
    public $model_select_id_cp;
    public $model_type = '';
    public $model_id = '';
    public $key_model_type;
    public $key_model_id;

    public function render()
    {
        return view('adminro::livewire.model-select');
    }

    public function mount(ControllerSettings $controllerSettings)
    {
        $this->form = $this->form->attributes();
        $this->model = $controllerSettings->model()->model();
        $this->edit_mode = $controllerSettings->request()->editMode();
        $this->model_select_type = $controllerSettings->formFields()->modelSelect($this->key . '_type')->attributes();
        $this->model_select_id = $controllerSettings->formFields()->modelSelect($this->key . '_id')->attributes();
        $this->model_select_type_cp = $this->model_select_type;
        $this->model_select_id_cp = $this->model_select_id;

        if (!$this->form['hidden_value']) {
            if ($this->edit_mode) {
                $this->model_type = $this->model_select_type['items_selected'][0] ?? '';
                $this->model_id = $this->model_select_id['items_selected'][0] ?? '';
            } else {
                $this->model_type = $this->model_select_type['items_selected'][0] ?? '';
                $this->model_id = $this->model_select_id['items_selected'][0] ?? '';

                if (!$this->model_type) {
                    $this->model_type = $controllerSettings->request()->request()->old($this->key . '_type') ?? '';
                }

                if (!$this->model_id) {
                    $this->model_id = $controllerSettings->request()->request()->old($this->key . '_id') ?? '';
                }
            }

            if ($this->model_type) {
                $this->updateModelIdItems();
            }
        }

        $this->key_model_type = $this->key . '_' . 'model_type';
        $this->key_model_id = $this->key . '_' . 'model_id';
        $this->{$this->key_model_type} = $this->model_type;
        $this->{$this->key_model_id} = $this->model_id;
    }

    protected function getListeners()
    {
        $listeners = collect();
        foreach ($this->model_select_type['listeners'] as $select_listener) {
            $listeners->put($select_listener['key_listener'] . '_changed', 'handleListenerFunctions');
        }

        foreach ($this->model_select_id['listeners'] as $select_listener) {
            $listeners->put($select_listener['key_listener'] . '_changed', 'handleListenerFunctions');
        }

        ray(['key' => $this->key, 'method' => 'getListeners', 'listeners' => $listeners]);

        return $listeners->toArray();
    }

    public function handleListenerFunctions($key, $value)
    {
        $listener_type = collect($this->model_select_type['listeners'])->firstWhere('key_listener', $key);
        if ($listener_type) {
            foreach ($listener_type['functions'] as $function) {
                if (!method_exists($this, $function)) {
                    break;
                }

                $this->$function($key, $value);
            }
        }

        $listener_id = collect($this->model_select_id['listeners'])->firstWhere('key_listener', $key);
        if ($listener_id) {
            foreach ($listener_id['functions'] as $function) {
                if (!method_exists($this, $function)) {
                    break;
                }

                $this->$function($key, $value);
            }
        }
    }

    public function updated($name, $value)
    {
        if ($name == 'model_type') {
            $this->emit($this->key_model_type . '_changed', $this->key_model_type, $value);
        } else if ($name == 'model_id') {
            ray(['key' => $this->key, 'method' => 'updated', $this->key_model_id . '_changed' => $this->{$this->key_model_id}]);
            $this->emit($this->key_model_id . '_changed', $this->key_model_id, $value);
        } else {
            $this->emit($this->key, $this->key, $value);
        }
    }

    public function onModelTypeChange()
    {
        ray(['key' => $this->key, 'method' => 'onModelTypeChange']);
        $this->{$this->key_model_type} = $this->model_type;

        $this->reset('model_id');
        $this->emit($this->key_model_id . '_changed', $this->key_model_id, '');

        $this->updateModelIdItems();
        $this->rebuildSelects();
    }

    public function onModelIdChange()
    {
        $this->{$this->key_model_id} = $this->model_id;

        $this->rebuildSelects();
    }

    public function updateModelIdItems()
    {
        ray(['key' => $this->key, $this->key_model_type => $this->{$this->key_model_type}, $this->key_model_id => $this->{$this->key_model_id}]);
        if (property_exists($this, 'model_model_id')) {
            ray(['model_model_id' => $this->model_model_id]);
        }

        if (!$this->{$this->key_model_type}) {
            ray(['key' => $this->key, 'method' => 'onModelTypeChange', 'return' => true]);
            $this->model_select_id['items'] = [];
            return;
        }

        if ($this->model_select_id['static_items']) {
            ray(['key' => $this->key, 'method' => 'onModelTypeChange', 'static_items' => true]);
            $this->model_select_id['items'] = $this->model_select_id_cp['items'];
        } else {
            ray(['key' => $this->key, 'method' => 'onModelTypeChange', 'getSelectQueryItems' => true]);
            $this->model_select_id['items'] = Select::make(items: getSelectQueryItems($this->model_select_id, $this), attributes: $this->model_select_id)->attributes()['items'];
        }
    }

    public function rebuildSelects()
    {
        ray(['key' => $this->key, 'method' => 'rebuildSelects']);
        $this->dispatchBrowserEvent('contentChanged', ['key' => $this->key . '_type', 'type' => 'selectpicker']);
        $this->dispatchBrowserEvent('contentChanged', ['key' => $this->key . '_id', 'type' => 'selectpicker']);
    }

    public function resetModelType()
    {
        ray(['key' => $this->key, 'method' => 'resetModelType']);
        $this->reset('model_type');
    }

    public function resetModelId()
    {
        ray(['key' => $this->key, 'method' => 'resetModelId']);
        $this->reset('model_id');
    }
}
