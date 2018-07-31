<?php

namespace App\Evostorm\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
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
            'App\Evostorm\Repositories\MissionRepositoryInterface',
            'App\Evostorm\Repositories\Eloquent\MissionRepository'
        );

        $this->app->bind(
            'App\Evostorm\Repositories\UserRepositoryInterface',
            'App\Evostorm\Repositories\Eloquent\UserRepository'
        );

        $this->app->bind(
            'App\Evostorm\Repositories\BuildingRepositoryInterface',
            'App\Evostorm\Repositories\Eloquent\BuildingRepository'
        );

        $this->app->bind(
            'App\Evostorm\Repositories\GameMapRepositoryInterface',
            'App\Evostorm\Repositories\Eloquent\GameMapRepository'
        );

        $this->app->bind(
            'App\Evostorm\Repositories\SpeciesRepositoryInterface',
            'App\Evostorm\Repositories\Eloquent\SpeciesRepository'
        );
    }
}
