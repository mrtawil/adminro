<?php

namespace Adminro\Providers;

use Illuminate\Support\ServiceProvider;

class AdminroServiceProvider extends ServiceProvider
{
  public function register()
  {
  }

  public function boot()
  {
    $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'adminro');
  }
}
