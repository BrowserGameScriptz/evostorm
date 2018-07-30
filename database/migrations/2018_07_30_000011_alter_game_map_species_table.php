<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterGameMapSpeciesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('game_map', function (Blueprint $table) {
            $table->unsignedInteger('species_id')->after('tile_type_id')->nullable();
            $table->foreign('species_id')->references('id')->on('species')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedInteger('species_amount')->after('species_id')->default(0);
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
