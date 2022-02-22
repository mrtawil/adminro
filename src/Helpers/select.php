<?php

function isPaginationMore($page, $count, $page_limit = null)
{
    if ($page_limit === null) {
        $page_limit = config('adminro.select_page_limit');
    }

    return $page * $page_limit < $count;
}
