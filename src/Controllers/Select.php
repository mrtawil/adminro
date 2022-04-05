<?php

namespace Adminro\Controllers;

use Adminro\Classes\Select as SelectClass;

class Select
{
    protected $controllerSettings;
    protected $page_limit;
    protected $items = [];
    protected $count = 0;
    protected $pagination_more = false;
    protected $custom_query;
    private $get_items = false;

    public function __construct($controllerSettings)
    {
        $this->controllerSettings = $controllerSettings;
    }

    public function controllerSettings(): ControllerSettings
    {
        return $this->controllerSettings;
    }

    public function setPageLimit($page_limit)
    {
        $this->page_limit = $page_limit;
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

    public function setCustomQuery($custom_query)
    {
        $this->custom_query = $custom_query;
    }

    public function pageLimit()
    {
        return $this->page_limit;
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

    public function customQuery()
    {
        return $this->custom_query;
    }

    public function validateParams()
    {
        $active_request = $this->controllerSettings()->request()->validatedKey('active_request');
        if (!isset($active_request['params'])) {
            return true;
        }

        foreach ($active_request['params'] as $param) {
            if ($this->controllerSettings()->request()->request()->input($param) === null) {
                return false;
            }
        }

        return true;
    }

    public function getItems()
    {
        $this->get_items = true;

        if (!$this->validateParams()) {
            $this->setItems([]);
            $this->setCount(0);
            $this->setPaginationMore(false);
            return;
        }

        if ($this->customQuery()) {
            $model = $this->customQuery();
        } else {
            $model = $this->controllerSettings()->model()->class()::selectItems();
        }

        $model->when($this->controllerSettings()->request()->requestKey('q'), function ($query) {
            $query->selectSearch($this->controllerSettings()->request()->validatedKey('q'));
        });;

        $active_request = $this->controllerSettings()->request()->validatedKey('active_request');
        if (isset($active_request['params'])) {
            foreach ($active_request['params'] as $param) {
                if (is_array($this->controllerSettings()->request()->request()->input($param))) {
                    $model->whereIn($param, $this->controllerSettings()->request()->request()->input($param));
                } else {
                    $model->where($param, $this->controllerSettings()->request()->request()->input($param));
                }
            }
        }

        $model_count = clone $model;
        $model_count = $model_count->count();

        $model = $model
            ->selectPaginate($this->controllerSettings()->request()->validatedKey('page'), $this->pageLimit())
            ->get();

        $select = SelectClass::make($model, attributes: json_decode((string)$this->controllerSettings()->request()->validatedKey('select'), true));

        $this->setItems($select->attributes()['items']);
        $this->setCount($model_count);
        $this->setPaginationMore(isPaginationMore($this->controllerSettings()->request()->validatedKey('page'), $model_count));
    }
}
