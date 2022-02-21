<?php

namespace Adminro\Controllers;

use Adminro\Classes\Select as SelectClass;

class Select
{
    protected $controllerSettings;
    protected $items = [];
    protected $count = 0;
    protected $pagination_more = false;
    private $get_items = false;

    public function __construct($controllerSettings)
    {
        $this->controllerSettings = $controllerSettings;
    }

    public function controllerSettings(): ControllerSettings
    {
        return $this->controllerSettings;
    }

    public function setItems($items)
    {
        $this->items = $items;
    }

    public function setCount($count)
    {
        $this->count = $count;
    }

    public function setPaginationMore($pagination_more)
    {
        $this->pagination_more = $pagination_more;
    }

    public function items()
    {
        if (!$this->get_items) {
            $this->getItems();
        }

        return $this->items;
    }

    public function count()
    {
        if (!$this->get_items) {
            return $this->getItems();
        }

        return $this->count;
    }

    public function paginationMore()
    {
        if (!$this->get_items) {
            return $this->getItems();
        }

        return $this->pagination_more;
    }

    public function getItems()
    {
        $this->get_items = true;

        $model = $this->controllerSettings()->model()->class()
            ::selectItems()
            ->when($this->controllerSettings()->request()->validatedKey('q'), function ($query) {
                $query->where('title', 'LIKE', '%' . $this->controllerSettings()->request()->validatedKey('q') . '%');
            });

        $model_count = clone $model;
        $model_count = $model_count->count();

        $model = $model
            ->selectPaginate($this->controllerSettings()->request()->validatedKey('page'))
            ->get();

        $select = SelectClass::make($model, attributes: json_decode((string) $this->controllerSettings()->request()->validatedKey('select'), true));

        $this->setItems($select->attributes()['items']);
        $this->setCount($model_count);
        $this->setPaginationMore(isPaginationMore($this->controllerSettings()->request()->validatedKey('page'), $model_count));
    }
}
