<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMissionsTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mission_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('short_name');
            $table->string('name');
        });

        Schema::create('mission_status', function (Blueprint $table) {
            $table->increments('id');
            $table->string('short_name');
            $table->string('name');
        });

        Schema::create('mission_costs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('mission_type_id');
            $table->foreign('mission_type_id')->references('id')->on('mission_types')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedInteger('gold_cost');
            $table->unsignedInteger('uranium_cost');
            $table->unsignedInteger('kegrum_cost');
            $table->unsignedInteger('time_cost'); // in minutes
        });

        Schema::create('missions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedInteger('mission_type_id');
            $table->foreign('mission_type_id')->references('id')->on('mission_types')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedInteger('mission_status_id');
            $table->foreign('mission_status_id')->references('id')->on('mission_status')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedInteger('tile_id')->nullable();
            $table->foreign('tile_id')->references('id')->on('game_map')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->text('result')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();
        });

        Schema::create('missions_queue', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('mission_id');
            $table->foreign('mission_id')->references('id')->on('missions')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->dateTime('finish_time')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }

}
