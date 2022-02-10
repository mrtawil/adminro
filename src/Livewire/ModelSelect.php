<?php

namespace Adminro\Livewire;

use Adminro\Classes\Select;
use Adminro\Controllers\ControllerSettings;
use Livewire\Component;

class ModelSelect extends Component
{
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
  }

  public function updated($name, $value)
  {
    if ($name == 'model_type') {
      $this->emit($this->key . '_type_changed', $this->key . '_type', $value);
    } else if ($name == 'model_id') {
      $this->emit($this->key . '_id_changed', $this->key . '_id', $value);
    } else {
      $this->emit($this->key, $this->key, $value);
    }
  }

  public function onModelTypeChange()
  {
    $this->dispatchBrowserEvent('loaderState', ['state' => 'show']);

    $this->reset('model_id');
    $this->emit($this->key . '_id_changed', $this->key . '_id', '');

    $this->updateModelIdItems();
    $this->rebuildSelects();

    $this->dispatchBrowserEvent('loaderState', ['state' => 'hide']);
  }

  public function onModelIdChange()
  {
    $this->rebuildSelects();
  }

  public function updateModelIdItems()
  {
    if (!$this->model_type) {
      $this->model_select_id['items'] = [];
      return;
    }

    if ($this->model_select_id['static_items']) {
      $this->model_select_id['items'] = $this->model_select_id_cp['items'];
    } else {
      $this->model_select_id['items'] = Select::make(items: getSelectQueryItems($this->model_select_type, $this), attributes: $this->model_select_id)->attributes()['items'];
    }
  }

  public function rebuildSelects()
  {
    $this->dispatchBrowserEvent('contentChanged', ['key' => $this->key . '_type', 'type' => 'selectpicker']);
    $this->dispatchBrowserEvent('contentChanged', ['key' => $this->key . '_id', 'type' => 'selectpicker']);
  }
}
