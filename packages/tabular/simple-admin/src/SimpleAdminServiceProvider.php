<?php

namespace Tabular\SimpleAdmin;

use Illuminate\Support\ServiceProvider;

class SimpleAdminServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (is_dir(base_path() . '/resources/views/tabular/simpleAdmin')) {
            $this->loadViewsFrom(base_path() . '/resources/views/tabular/simpleAdmin', 'simpleAdmin');
        } else {
            $this->loadViewsFrom(__DIR__.'/views', 'simpleAdmin');
        }

        $this->publishes([
            __DIR__.'/views' => base_path('resources/views/tabular/simpleAdmin'),
        ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__.'/routes.php';
    }
}
