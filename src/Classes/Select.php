<?php

namespace Adminro\Classes;

class Select
{
    protected $items = [];
    protected $items_selected = [];
    protected $title_prefix = '';
    protected $title_key = 'title';
    protected $title_capitalize = false;
    protected $value_key = 'id';
    protected $additional = [];
    protected $empty_option = true;
    protected $static_items = true;
    protected $listeners = [];
    protected $default_request;
    protected $conditional_requests = [];

    public function __construct($attributes = [])
    {
        if (isset($attributes['items'])) $this->setItems($attributes['items']);
        if (isset($attributes['items_selected'])) $this->setItemsSelected($attributes['items_selected']);
        if (isset($attributes['title_prefix'])) $this->setTitlePrefix($attributes['title_prefix']);
        if (isset($attributes['title_key'])) $this->setTitleKey($attributes['title_key']);
        if (isset($attributes['title_capitalize'])) $this->setTitleCapitalize($attributes['title_capitalize']);
        if (isset($attributes['value_key'])) $this->setValueKey($attributes['value_key']);
        if (isset($attributes['empty_option'])) $this->setEmptyOption($attributes['empty_option']);
        if (isset($attributes['static_items'])) $this->setStaticItems($attributes['static_items']);
        if (isset($attributes['default_request'])) $this->setDefaultRequest(SelectRequest::make($attributes['default_request']));

        if (isset($attributes['additional'])) {
            foreach ($attributes['additional'] as $additional) {
                $this->addAdditional(Select::make(attributes: $additional));
            }
        }

        if (isset($attributes['listeners'])) {
            foreach ($attributes['listeners'] as $listener) {
                $this->addListener(SelectListener::make(attributes: $listener));
            }
        }

        if (isset($attributes['conditional_requests'])) {
            foreach ($attributes['conditional_requests'] as $conditional_request) {
                $this->addConditionalRequest(SelectConditonalRequest::make(attributes: $conditional_request));
            }
        }
    }

    static public function make($items = null, $items_selected = null, $attributes = [])
    {
        if ($items !== null) {
            $attributes['items'] = $items;
        }

        if ($items_selected !== null) {
            $attributes['items_selected'] = $items_selected;
        }

        return new static($attributes);
    }

    public function setItems($items)
    {
        $this->items = $items;

        return $this;
    }

    public function setItemsSelected($items_selected)
    {
        if (!is_array($items_selected)) {
            $items_selected = [$items_selected];
        }

        $this->items_selected = $items_selected;

        return $this;
    }

    public function setTitlePrefix($title_prefix)
    {
        $this->title_prefix = $title_prefix;

        return $this;
    }

    public function setTitleKey($title_key)
    {
        $this->title_key = $title_key;

        return $this;
    }

    public function setTitleCapitalize($title_capitalize)
    {
        $this->title_capitalize = $title_capitalize;

        return $this;
    }

    public function setValueKey($value_key)
    {
        $this->value_key = $value_key;

        return $this;
    }

    public function setAdditional($additional)
    {
        $this->additional = $additional;

        return $this;
    }

    public function addAdditional(Select $select)
    {
        array_push($this->additional, $select);

        return $this;
    }

    public function setEmptyOption($empty_option)
    {
        $this->empty_option = $empty_option;

        return $this;
    }

    public function setStaticItems($static_items)
    {
        $this->static_items = $static_items;

        return $this;
    }

    public function setListeners($listeners)
    {
        $this->listeners = $listeners;

        return $this;
    }

    public function addListener(SelectListener $select_listener)
    {
        array_push($this->listeners, $select_listener);

        return $this;
    }

    public function setDefaultRequest($default_request)
    {
        $this->default_request = $default_request;

        return $this;
    }

    public function setConditionalRequests($conditional_requests)
    {
        $this->conditional_requests = $conditional_requests;

        return $this;
    }

    public function addConditionalRequest(SelectConditonalRequest $conditional_request)
    {
        array_push($this->conditional_requests, $conditional_request);

        return $this;
    }

    public function items()
    {
        return $this->items;
    }

    public function itemsSelected()
    {
        return $this->items_selected;
    }

    public function titlePrefix()
    {
        return $this->title_prefix;
    }

    public function titleKey()
    {
        return $this->title_key;
    }

    public function titleCapitalize()
    {
        return $this->title_capitalize;
    }

    public function valueKey()
    {
        return $this->value_key;
    }

    public function additional()
    {
        return $this->additional;
    }

    public function emptyOption()
    {
        return $this->empty_option;
    }

    public function staticItems()
    {
        return $this->static_items;
    }

    public function listeners()
    {
        return $this->listeners;
    }

    public function defaultRequest()
    {
        return $this->default_request;
    }

    public function conditionalRequests()
    {
        return $this->conditional_requests;
    }

    public function title($item)
    {
        $title = getObjectAttribute($item, $this->titleKey());

        if ($this->titleCapitalize()) {
            $title = ucwords($title);
        }

        if ($this->titlePrefix()) {
            $title = $this->titlePrefix() . $title;
        }

        foreach ($this->additional() as $additional) {
            $title = $title . $additional->title($item);
        }

        return $title;
    }

    public function value($item)
    {
        return getObjectAttribute($item, $this->valueKey());
    }

    public function attributes()
    {
        $items = collect($this->items())->map(function ($item) {
            $item['id'] = $this->value($item);
            $item['text'] = $this->title($item);
            return $item;
        });

        $additional = collect($this->additional())->map(function ($additional) {
            return $additional->attributes();
        });

        $listeners = collect($this->listeners())->map(function ($listener) {
            return $listener->attributes();
        });

        $default_request = $this->defaultRequest();
        if ($default_request) $default_request = $default_request->attributes();

        $conditional_requests = collect($this->conditionalRequests())->map(function ($conditional_request) {
            return $conditional_request->attributes();
        });

        $attributes = [
            'items' => $items,
            'items_selected' => $this->itemsSelected(),
            'title_prefix' => $this->titlePrefix(),
            'title_key' => $this->titleKey(),
            'title_capitalize' => $this->titleCapitalize(),
            'value_key' => $this->valueKey(),
            'additional' => $additional,
            'empty_option' => $this->emptyOption(),
            'static_items' => $this->staticItems(),
            'listeners' => $listeners,
            'default_request' => $default_request,
            'conditional_requests' => $conditional_requests,
        ];

        return $attributes;
    }
}
