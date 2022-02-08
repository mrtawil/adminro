<?php

function customizeRules($rules, $model)
{
  if (!is_array($rules)) {
    $rules = [$rules];
  }

  if ($model) {
    $rules = Str::replace(':id', $model->id, json_encode($rules));
    $rules = (array)json_decode($rules);
  }

  return $rules;
}
