<?php

namespace Adminro\Classes;

class SelectRequest
{
    protected $url;
    protected $params = [];

    public function __construct($attributes = [])
    {
        if (isset($attributes['url'])) $this->setUrl($attributes['url']);
        if (isset($attributes['params'])) $this->setParams($attributes['params']);
    }

    static public function make($url = null, $params = null, $attributes = [])
    {
        if ($url !== null) {
            $attributes['url'] = $url;
        }

        if ($params !== null) {
            $attributes['params'] = $params;
        }

        return new static($attributes);
    }

    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    public function setParams($params)
    {
        $this->params = $params;

        return $this;
    }

    public function url()
    {
        return $this->url;
    }

    public function params()
    {
        return $this->params;
    }

    public function attributes()
    {
        $attributes = [
            'url' => $this->url(),
            'params' => $this->params(),
        ];

        return $attributes;
    }
}
