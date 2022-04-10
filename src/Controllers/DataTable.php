<?php

namespace Adminro\Controllers;

use Adminro\Constants\Constants;
use Exception;

class DataTable
{
    protected $controllerSettings;
    protected $dataTable;
    protected $dataTable_class;
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

    public function setDataTableClass($dataTable_class)
    {
        $this->dataTable_class = $dataTable_class;
    }

    public function dataTable()
    {
        return $this->dataTable;
    }

    public function forms()
    {
        return $this->forms;
    }

    public function dataTableClass()
    {
        return $this->dataTable_class;
    }

    public function initDataTable($class = null)
    {
        if (!$class) {
            $class = $this->dataTableClass();
        }

        if (!$class) {
            throw new Exception('Datatable class is missing.');
        }

        $this->setDataTable(app($class, ['controllerSettings' => $this->controllerSettings()]));
        $this->addColumnsForms();
        $this->setFormOption('status', 'options', Constants::STATUS_PUBLISH_WITH_DELETED);
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
        foreach ($this->dataTable()->getColumns() as $key => $column) {
            if ($column['type'] == 'string') {
                $this->addForm($column['data'], [
                    'index' => $key,
                    'type' => 'string',
                    'title' => $column['title'],
                ]);
            }

            if ($column['type'] == 'int') {
                $this->addForm($column['data'], [
                    'index' => $key,
                    'type' => 'int',
                    'title' => $column['title'],
                ]);
            }

            if ($column['type'] == 'select') {
                $this->addForm($column['data'], [
                    'index' => $key,
                    'type' => 'select',
                    'title' => $column['title'],
                    'options' => [],
                ]);
            }

            if ($column['type'] == 'date_range') {
                $this->addForm($column['data'], [
                    'index' => $key,
                    'type' => 'date_range',
                    'title' => $column['title'],
                ]);
            }
        }
    }
}
