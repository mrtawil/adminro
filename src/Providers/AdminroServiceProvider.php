<?php

namespace Adminro\Providers;

use Adminro\Console\Commands\RefreshPermissions;
use Adminro\Console\Commands\RefreshTablesWithDummy;
use Illuminate\Support\ServiceProvider;

class AdminroServiceProvider extends ServiceProvider
{
  public function register()
  {
  }

  public function boot()
  {
    $this->loadViewsFrom(__DIR__ . '/../resources/views', 'adminro');
    $this->publishes([__DIR__ . '/../public' => public_path('vendor/adminro')], 'adminro::public');
    if ($this->app->runningInConsole()) {
      $this->commands([
        RefreshPermissions::class,
        RefreshTablesWithDummy::class,
      ]);
    }
  }
}
