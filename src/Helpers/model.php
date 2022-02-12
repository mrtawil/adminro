<?php

use Illuminate\Support\Arr;

function getFillable($class_name)
{
    if (!method_exists($class_name, 'getFillable')) {
        return [];
    }

    $class = new $class_name();
    return $class->getFillable();
}

function getSpatialFields($class_name)
{
    if (!method_exists($class_name, 'getSpatialFields')) {
        return [];
    }

    $class = new $class_name();
    return $class->getSpatialFields();
}

function getFileFormKeys($class)
{
    $file_form_fileds = Arr::where($class::formFields(), fn ($form) => in_array($form->type(), ['file', 'image', 'video']));
    return array_keys($file_form_fileds);
}

function filterModelValidated($class, $validated, $is_post_save)
{
    $validated = Arr::except($validated, getSpatialFields($class));
    $validated = Arr::only($validated, getFillable($class));

    if (!$is_post_save) {
        $validated = Arr::except($validated, getFileFormKeys($class));
    }

    return $validated;
}
