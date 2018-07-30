<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpeciesTables extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('species_genomes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable(); // author of the genome
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->timestamps();
        });

        Schema::create('species', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name'); // name of the species given by the author
            $table->unsignedInteger('user_id')->nullable(); // author of the species
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedInteger('genome_id'); // genome of the species
            $table->foreign('genome_id')->references('id')->on('species_genomes')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedInteger('strength'); // species strength range 1-100
            $table->unsignedInteger('endurance');
            $table->unsignedInteger('food_requirements');
            $table->unsignedInteger('reproduction');
            $table->unsignedInteger('death_rate');
            $table->unsignedInteger('intellect');
            $table->unsignedInteger('productivity');
            $table->timestamps();
        });

        Schema::create('users_has_species', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedInteger('species_id');
            $table->foreign('species_id')->references('id')->on('species')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedInteger('count_total')->default(0);
            $table->unsignedInteger('count_assigned')->default(0);
            $table->unsignedInteger('count_unassigned')->default(0);
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
