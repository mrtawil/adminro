<?php

namespace Adminro\Traits;

trait SelectLivewire
{
    public function storeProperty($key, $value)
    {
        ray(['key' => $this->key, 'curr_key' => $key, 'value' => $value, 'method' => 'storeProperty']);
        $this->$key = $value;
    }
}
