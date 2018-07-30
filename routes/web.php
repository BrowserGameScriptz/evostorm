<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | This file is where you may define all of the routes that are handled
  | by your application. Just tell Laravel the URIs it should respond
  | to using a Closure or controller method. Build something great!
  |
 */

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@index');
    Route::group(['prefix' => 'api'], function () {

        Route::post('user/resources', [
            'uses' => 'ResourcesController@getUsersCurrentResources'
        ]);

        Route::post('user/map', [
            'uses' => 'GameMapController@getUserMap'
        ]);

        Route::post('user/missions', [
            'uses' => 'MissionsController@getUserMissions'
        ]);

        Route::post('user/mission/abort/{mission_id}', [
            'uses' => 'MissionsController@abortUserMission'
        ])->where('mission_id', '[0-9]+');

        Route::post('tile/info/{id}', [
            'uses' => 'TilesController@getTileInfo'
        ])->where('id', '[0-9]+');

        Route::post('build/{building_level_id}/{tile_id}', [
            'uses' => 'BuildingsController@build'
        ])->where('building_level_id', '[0-9]+')
            ->where('tile_id', '[0-9]+');

        // Missions
        Route::post('mission/capture/{tile_id}', [
            'uses' => 'MissionsController@sendForCaptureMission'
        ])->where('tile_id', '[0-9]+');

        Route::post('mission/estimate_resources/{tile_id}', [
            'uses' => 'MissionsController@sendForResourcesEstimationMission'
        ])->where('tile_id', '[0-9]+');

        // Buildings
        Route::post('user/buildings', [
            'uses' => 'BuildingsController@getUserBuildings'
        ]);
    });
});

