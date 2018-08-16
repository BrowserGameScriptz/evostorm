<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameMapTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tile_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('tiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('coord_x');
            $table->integer('coord_y');
            $table->integer('gold_left')->default(0);
            $table->integer('uranium_left')->default(0);
            $table->integer('kegrum_left')->default(0);
            $table->integer('gold_usage')->default(0);
            $table->integer('uranium_usage')->default(0);
            $table->integer('kegrum_usage')->default(0);
            $table->boolean('is_used')->default(false)->index();
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedInteger('tile_type_id')->default(1);
            $table->foreign('tile_type_id')->references('id')->on('tile_types')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->boolean('is_resources_estimated')->default(false);
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
