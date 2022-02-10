<?php

namespace Adminro\Livewire;

use Adminro\Classes\Select;
use Adminro\Controllers\ControllerSettings;
use Livewire\Component;

class DynamicSelect extends Component
{
  public $key;
  public $form;
  public $model;
  public $edit_mode;
  public $dynamic_select;
  public $dynamic_value = '';

  public function render()
  {
    return view('adminro::livewire.dynamic-select');
  }

  public function mount(ControllerSettings $controllerSettings)
  {
    $this->form = $this->form->attributes();
    $this->model = $controllerSettings->model()->model();
    $this->edit_mode = $controllerSettings->request()->editMode();
    $this->dynamic_select = $controllerSettings->formFields()->dynamicSelect($this->key)->attributes();

    foreach ($this->dynamic_select['listeners'] as $listener) {
      if ($listener['default'] === null) {
        continue;
      }

      $key_listener = $listener['key_listener'];
      $this->$key_listener = $listener['default'];
    }

    if (!$this->form['hidden_value']) {
      if ($this->edit_mode) {
        $this->dynamic_value = $this->dynamic_select['items_selected'][0] ?? '';
      } else {
        $this->dynamic_value = $this->dynamic_select['items_selected'][0] ?? '';

        if (!$this->dynamic_value) {
          $this->dynamic_value = $controllerSettings->request()->request()->old($this->key) ?? '';
        }
      }

      if ($this->dynamic_value) {
        $this->updateDynamicItems();
      }
    }
  }

  protected function getListeners()
  {
    $listeners = collect();
    foreach ($this->dynamic_select['listeners'] as $dynamic_select_listener) {
      $listeners->put($dynamic_select_listener['key_listener'] . '_changed', 'handleListenerFunctions');
    }

    return $listeners->toArray();
  }

  public function handleListenerFunctions($key, $value)
  {
    $listener = collect($this->dynamic_select['listeners'])->firstWhere('key_listener', $key);
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
    $this->emit($this->key, $this->key, $value);
  }

  public function storeProperty($key, $value)
  {
    $this->$key = $value;
    $this->rebuildSelects();
  }

  public function resetDynamicValue()
  {
    $this->reset('dynamic_value');
  }

  public function updateDynamicItems()
  {
    $this->dynamic_select['items'] = Select::make(items: getSelectQueryItems($this->dynamic_select, $this), attributes: $this->dynamic_select)->attributes()['items'];
    $this->rebuildSelects();
  }

  public function onDynamicValueChange()
  {
    $this->emit($this->key . '_changed');
    $this->rebuildSelects();
  }

  public function rebuildSelects()
  {
    $this->dispatchBrowserEvent('contentChanged', ['key' => $this->key, 'type' => 'selectpicker']);
  }
}
