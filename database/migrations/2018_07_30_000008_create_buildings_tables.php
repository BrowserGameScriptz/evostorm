<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Enums\BuildingStatusEnum;

class CreateBuildingsTables extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('building_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('short_name');
            $table->string('name');
        });

        Schema::create('building_status', function (Blueprint $table) {
            $table->increments('id');
            $table->string('short_name');
            $table->string('name');
        });

        Schema::create('building_types_allowed_tile_types', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('building_type_id')->nullable();
            $table->foreign('building_type_id')->references('id')->on('building_types')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedInteger('tile_type_id')->nullable();
            $table->foreign('tile_type_id')->references('id')->on('tile_types')->onUpdate('CASCADE')->onDelete('CASCADE');
        });

        Schema::create('building_levels', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('building_type_id')->nullable();
            $table->foreign('building_type_id')->references('id')->on('building_types')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedInteger('level');
            $table->unsignedInteger('gold_cost');
            $table->unsignedInteger('uranium_cost');
            $table->unsignedInteger('kegrum_cost');
            $table->unsignedInteger('base_gold_production'); // Base gold production on maximal number of workers with 100% productivity
            $table->unsignedInteger('base_uranium_production'); // Base uranium production on maximal number of workers with 100% productivity
            $table->unsignedInteger('base_kegrum_production'); // Base kegrum production on maximal number of workers with 100% productivity
            $table->unsignedInteger('base_gold_upkeep');
            $table->unsignedInteger('base_uranium_upkeep');
            $table->unsignedInteger('base_kegrum_upkeep');
            $table->unsignedInteger('base_energy_consumption');
            $table->unsignedInteger('base_energy_production');
            $table->unsignedInteger('min_workers_amount'); // min amount of workers to run the facility
            $table->unsignedInteger('max_workers_amount'); // maximum amount of workers who can work there
            $table->unsignedInteger('build_time'); // building time in minutes
        });

        Schema::create('buildings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedInteger('game_map_id');
            $table->foreign('game_map_id')->references('id')->on('game_map')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedInteger('building_level_id');
            $table->foreign('building_level_id')->references('id')->on('building_levels')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedInteger('building_status_id')->default(BuildingStatusEnum::BUILDING_IN_PROGRESS);
            $table->foreign('building_status_id')->references('id')->on('building_status')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedInteger('actual_gold_production')->default(0);
            $table->unsignedInteger('actual_uranium_production')->default(0);
            $table->unsignedInteger('actual_kegrum_production')->default(0);
            $table->unsignedInteger('actual_energy_consumption')->default(0);
            $table->unsignedInteger('actual_energy_production')->default(0);
            $table->unsignedInteger('actual_gold_upkeep')->default(0);
            $table->unsignedInteger('actual_uranium_upkeep')->default(0);
            $table->unsignedInteger('actual_kegrum_upkeep')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }

}
