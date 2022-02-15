<?php

namespace Adminro\Classes;

class SelectListener
{
    protected $key_listener;
    protected $functions = [];
    protected $default;

    const DEFAULT_FUNCTIONS = [
        'storeProperty', 'resetValue', 'updateSelectItems', 'rebuildSelect'
    ];

    public function __construct($attributes = [])
    {
        if (isset($attributes['key_listener'])) $this->setKeyListener($attributes['key_listener']);
        if (isset($attributes['functions'])) $this->setFunction($attributes['functions']);
        if (isset($attributes['default'])) $this->setDefault($attributes['default']);
    }

    static public function make($key_listener = null, $functions = null, $default = null, $attributes = [])
    {
        if ($key_listener !== null) {
            $attributes['key_listener'] = $key_listener;
        }

        if ($functions !== null) {
            $attributes['functions'] = $functions;
        }

        if ($default !== null) {
            $attributes['default'] = $default;
        }

        return new static($attributes);
    }

    public function setKeyListener($key_listener)
    {
        $this->key_listener = $key_listener;

        return $this;
    }

    public function setFunction($functions)
    {
        $this->functions = $functions;

        return $this;
    }

    public function setDefault($default)
    {
        $this->default = $default;

        return $this;
    }

    public function keyListener()
    {
        return $this->key_listener;
    }

    public function functions()
    {
        return $this->functions;
    }

    public function default()
    {
        return $this->default;
    }

    public function attributes()
    {
        $attributes = [
            'key_listener' => $this->keyListener(),
            'functions' => $this->functions(),
            'default' => $this->default(),
        ];

        return $attributes;
    }
}
