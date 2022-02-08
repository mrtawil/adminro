<?php

namespace Adminro\Classes;

class SelectConditonalQuery
{
  protected $query;
  protected $conditional_key;
  protected $conditaional_value;

  public function __construct($attributes = [])
  {
    if (isset($attributes['query'])) $this->setQuery($attributes['query']);
    if (isset($attributes['conditional_key'])) $this->setConditionalKey($attributes['conditional_key']);
    if (isset($attributes['conditaional_value'])) $this->setConditionalValue($attributes['conditaional_value']);
  }

  static public function make($query = null, $conditional_key = null, $conditaional_value = null, $attributes = [])
  {
    if ($query !== null) {
      $attributes['query'] = $query;
    }

    if ($conditional_key !== null) {
      $attributes['conditional_key'] = $conditional_key;
    }

    if ($conditaional_value !== null) {
      $attributes['conditaional_value'] = $conditaional_value;
    }

    return new static($attributes);
  }

  public function setQuery($query)
  {
    $this->query = $query;

    return $this;
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

  public function query()
  {
    return $this->query;
  }

  public function conditionalKey()
  {
    return $this->conditional_key;
  }

  public function conditionalValue()
  {
    return $this->conditaional_value;
  }

  public function attributes()
  {
    $query = $this->query();
    if ($query instanceof SelectStringQuery) {
      $query = $query->attributes();
    }

    $attributes = [
      'query' => $query,
      'conditional_key' => $this->conditionalKey(),
      'conditional_value' => $this->conditionalValue(),
    ];

    return $attributes;
  }
}
