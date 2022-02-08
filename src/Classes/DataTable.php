<?php

namespace Adminro\Classes;

use Adminro\Controllers\ControllerSettings;
use Yajra\DataTables\Services\DataTable as YajraDataTable;

class DataTable extends YajraDataTable
{
  protected $controllerSettings;

  public function __construct($controllerSettings)
  {
    $this->controllerSettings = $controllerSettings;
  }

  public function controllerSettings(): ControllerSettings
  {
    return $this->controllerSettings;
  }

  public function dataTable($query)
  {
    return prepareDataTableSQL($this->controllerSettings(), $query);
  }

  public function html()
  {
    return prepareDataTableHTML($this, $this->getColumns());
  }

  public function getColumns()
  {
    return [];
  }

  public function filename()
  {
    return $this->controllerSettings()->info()->pluralTitle() . '_' . date('YmdHis');
  }
}
