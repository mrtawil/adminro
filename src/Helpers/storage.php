<?php

use Illuminate\Support\Facades\File;

function checkFolder($folder)
{
    if (!File::exists($folder)) {
        File::makeDirectory($folder, 0775, true);
    }
}
