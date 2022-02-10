<?php

namespace Adminro\Controllers;

use Adminro\Constants\SelectOptions;

class DataTable
{
    protected $controllerSettings;
    protected $dataTable;
    protected $forms = [];

    public function __construct($controllerSettings)
    {
        $this->controllerSettings = $controllerSettings;
    }

    public function controllerSettings(): ControllerSettings
    {
        return $this->controllerSettings;
    }

    public function setDataTable($dataTable)
    {
        $this->dataTable = $dataTable;
    }

    public function dataTable()
    {
        return $this->dataTable;
    }

    public function forms()
    {
        return $this->forms;
    }

    public function initDataTable($class)
    {
        $this->setDataTable(app($class, ['controllerSettings' => $this->controllerSettings()]));
        $this->addColumnsForms();
        $this->setFormOption('status', 'options', SelectOptions::PUBLISH_WITH_DELETED);
    }

    public function addForm($key, $options)
    {
        $this->forms[$key] = $options;
    }

    public function setFormOption($key, $option, $value)
    {
        if (!isset($this->forms[$key])) {
            return false;
        }

        $this->forms[$key][$option] = $value;
    }

    public function addColumnsForms()
    {
        $columns = collect($this->dataTable()->getColumns());
        foreach ($columns->where('searchable', true) as $column) {
            if ($column['type'] == 'string') {
                $this->addForm($column['data'], [
                    'type' => 'string',
                    'title' => $column['title'],
                ]);
            }

            if ($column['type'] == 'int') {
                $this->addForm($column['data'], [
                    'type' => 'int',
                    'title' => $column['title'],
                ]);
            }

            if ($column['type'] == 'select') {
                $this->addForm($column['data'], [
                    'type' => 'select',
                    'title' => $column['title'],
                    'options' => [],
                ]);
            }

            if ($column['type'] == 'date_range') {
                $this->addForm($column['data'], [
                    'type' => 'date_range',
                    'title' => $column['title'],
                ]);
            }
        }
    }
}
