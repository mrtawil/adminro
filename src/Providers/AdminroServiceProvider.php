<?php

namespace Adminro\Providers;

use Adminro\Console\Commands\RefreshPermissions;
use Adminro\Console\Commands\RefreshTablesWithDummy;
use Adminro\Livewire\DynamicSelect;
use Adminro\Livewire\ModelSelect;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AdminroServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'adminro');

        $this->publishes([__DIR__ . '/../public' => public_path('vendor/adminro')], 'adminro::public');

        Livewire::component('model-select', ModelSelect::class);
        Livewire::component('dynamic-select', DynamicSelect::class);

        if ($this->app->runningInConsole()) {
            $this->commands([
                RefreshPermissions::class,
                RefreshTablesWithDummy::class,
            ]);
        }
    }
}
