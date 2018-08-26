<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('costs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('gold');
            $table->unsignedInteger('uranium');
            $table->unsignedInteger('kegrum');
            $table->unsignedInteger('time'); // in minutes
        });
        Schema::dropIfExists('mission_costs');

        Schema::table('mission_types', function (Blueprint $table) {
            $table->unsignedInteger('cost_id')->after('name');
            $table->foreign('cost_id')->references('id')->on('costs')->onUpdate('CASCADE')->onDelete('CASCADE');
        });

        Schema::table('building_levels', function (Blueprint $table) {
            $table->dropColumn('gold_cost');
            $table->dropColumn('uranium_cost');
            $table->dropColumn('kegrum_cost');
            $table->dropColumn('build_time');
            $table->unsignedInteger('cost_id')->after('level');
            $table->foreign('cost_id')->references('id')->on('costs')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('costs');
    }
}
