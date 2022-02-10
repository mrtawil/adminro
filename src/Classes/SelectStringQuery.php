<?php

namespace Adminro\Classes;

class SelectStringQuery
{
    protected $query;
    protected $params = [];

    public function __construct($attributes = [])
    {
        if (isset($attributes['query'])) $this->setQuery($attributes['query']);
        if (isset($attributes['params'])) $this->setParams($attributes['params']);
    }

    static public function make($query = null, $attributes = [])
    {
        if ($query !== null) {
            $attributes['query'] = $query;
        }

        return new static($attributes);
    }

    public function setQuery($query)
    {
        $this->query = $query;

        return $this;
    }

    public function setParams($params)
    {
        $this->params = $params;

        return $this;
    }

    public function query()
    {
        return $this->query;
    }

    public function params()
    {
        return $this->params;
    }

    public function attributes()
    {
        $attributes = [
            'class' => get_class($this),
            'query' => $this->query(),
            'params' => $this->params(),
        ];

        return $attributes;
    }
}
