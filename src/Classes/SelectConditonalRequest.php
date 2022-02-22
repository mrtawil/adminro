<?php

namespace Adminro\Classes;

class SelectConditonalRequest
{
    protected $conditional_key;
    protected $conditaional_value;
    protected $request;

    public function __construct($attributes = [])
    {
        if (isset($attributes['conditional_key'])) $this->setConditionalKey($attributes['conditional_key']);
        if (isset($attributes['conditaional_value'])) $this->setConditionalValue($attributes['conditaional_value']);
        if (isset($attributes['request'])) $this->setRequest($attributes['request']);
    }

    static public function make($conditional_key = null, $conditaional_value = null, $request = null, $attributes = [])
    {
        if ($conditional_key !== null) {
            $attributes['conditional_key'] = $conditional_key;
        }

        if ($conditaional_value !== null) {
            $attributes['conditaional_value'] = $conditaional_value;
        }

        if ($request !== null) {
            $attributes['request'] = $request;
        }

        return new static($attributes);
    }

    public function setConditionalKey($conditional_key)
    {
        $this->conditional_key = $conditional_key;

        return $this;
    }

    public function setConditionalValue($conditaional_value)
    {
        $this->conditaional_value = $conditaional_value;

        return $this;
    }

    public function setRequest($request)
    {
        $this->request = $request;

        return $this;
    }

    public function setParams($params)
    {
        $this->params = $params;

        return $this;
    }

    public function conditionalKey()
    {
        return $this->conditional_key;
    }

    public function conditionalValue()
    {
        return $this->conditaional_value;
    }

    public function request()
    {
        return $this->request;
    }

    public function params()
    {
        return $this->params;
    }

    public function attributes()
    {
        $request = $this->request();
        if ($request instanceof SelectRequest) {
            $request = $request->attributes();
        }

        $attributes = [
            'conditional_key' => $this->conditionalKey(),
            'conditional_value' => $this->conditionalValue(),
            'request' => $request,
        ];

        return $attributes;
    }
}
