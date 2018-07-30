<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuildingsWorkersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('buildings_workers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('building_id');
            $table->foreign('building_id')->references('id')->on('buildings')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedInteger('species_id');
            $table->foreign('species_id')->references('id')->on('species')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedInteger('amount')->default(0);
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
