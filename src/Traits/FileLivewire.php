<?php

namespace Adminro\Traits;

trait FileLivewire
{
    function removeFile()
    {
        removeFileFromStorage($this->model, $this->key, $this->form);
        $this->model->update([$this->key => null, $this->key . '_path' => null]);
    }
}
