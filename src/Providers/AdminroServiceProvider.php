<?php

namespace Adminro\Providers;

use Adminro\Console\Commands\RefreshPermissions;
use Adminro\Console\Commands\RefreshTablesWithDummy;
use Adminro\Livewire\File;
use Adminro\Livewire\Image;
use Adminro\Livewire\Select;
use Adminro\Livewire\Video;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AdminroServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/adminro.php', 'adminro');
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'adminro');

        $this->publishes([__DIR__ . '/../public' => public_path('vendor/adminro')], 'adminro::public');
        $this->publishes([__DIR__ . '/../config/adminro.php' => config_path('adminro.php')], 'adminro::config');

        Livewire::component('select', Select::class);
        Livewire::component('file', File::class);
        Livewire::component('image', Image::class);
        Livewire::component('video', Video::class);

        if ($this->app->runningInConsole()) {
            $this->commands([
                RefreshPermissions::class,
                RefreshTablesWithDummy::class,
            ]);
        }
    }
}
