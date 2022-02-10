<?php

use Adminro\Classes\Select;
use Adminro\Classes\SelectStringQuery;

function getSelectQueryItems($select, $class)
{
    $items = [];

    if (!$select) {
        goto end;
    }

    if ($select instanceof Select) {
        $select = $select->attributes();
    }

    conditional_queries:
    $conditional_queries = $select['conditional_queries'];
    if (count($conditional_queries) <= 0) {
        goto default_query;
    }

    foreach ($conditional_queries as $conditional_query) {
        $conditional_key = $conditional_query['conditional_key'];
        if (!property_exists($class, $conditional_key) || (property_exists($class, $conditional_key) && ($class->$conditional_key === null || $class->$conditional_key === ''))) {
            continue;
        }

        if ($class->$conditional_key != $conditional_query['conditional_value']) {
            continue;
        }

        switch ($conditional_query['query']['class']) {
            case SelectStringQuery::class:
                $items = getSelectStringQueryItems($conditional_query['query'], $class);
                break;
        }

        goto end;
    }

    default_query:
    $default_query = $select['default_query'];
    if ($default_query) {
        switch ($default_query['class']) {
            case SelectStringQuery::class:
                $items = getSelectStringQueryItems($default_query, $class);
                break;
        }

        goto end;
    }

    end:
    return $items;
}

function getSelectStringQueryItems($select_string_query, $class)
{
    $items = [];

    if (!$select_string_query) {
        goto end;
    }

    if ($select_string_query instanceof SelectStringQuery) {
        $select_string_query = $select_string_query->attributes();
    }

    $query = $select_string_query['query'];
    $params = $select_string_query['params'];

    foreach ($params as $key => $query_param) {
        if (!property_exists($class, $query_param) || (property_exists($class, $query_param) && ($class->$query_param === null || $class->$query_param === ''))) {
            goto end;
        }

        $query = Str::replace('{' . $key . '}', $class->$query_param, $query);
    }

    $output = null;
    eval("\$output={$query}");
    $items = $output;

    end:
    return $items;
}
