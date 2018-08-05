<?php

namespace App\Evostorm\Providers;

use Illuminate\Support\ServiceProvider;

class FacadeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Evostorm\Facades\Contracts\BuildingsFacadeInterface',
            'App\Evostorm\Facades\BuildingsFacade'
        );

        $this->app->bind(
            'App\Evostorm\Facades\Contracts\GameMapFacadeInterface',
            'App\Evostorm\Facades\GameMapFacade'
        );

        $this->app->bind(
            'App\Evostorm\Facades\Contracts\MissionsFacadeInterface',
            'App\Evostorm\Facades\MissionsFacade'
        );

        $this->app->bind(
            'App\Evostorm\Facades\Contracts\ResourcesFacadeInterface',
            'App\Evostorm\Facades\ResourcesFacade'
        );
    }
}
