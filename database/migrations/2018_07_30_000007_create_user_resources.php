<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserResources extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('users', function(Blueprint $table) {
            $table->bigInteger('amount_gold')->after('password')->default(0);
            $table->bigInteger('amount_uranium')->after('amount_gold')->default(0);
            $table->bigInteger('amount_food')->after('amount_uranium')->default(0);
            $table->bigInteger('amount_workforce')->after('amount_food')->default(0);
            $table->bigInteger('amount_kegrum')->after('amount_workforce')->default(0);

            $table->bigInteger('income_gold')->after('amount_kegrum')->default(0);
            $table->bigInteger('income_uranium')->after('income_gold')->default(0);
            $table->bigInteger('income_food')->after('income_uranium')->default(0);
            $table->bigInteger('income_workforce')->after('income_food')->default(0);
            $table->bigInteger('income_kegrum')->after('income_workforce')->default(0);

            $table->bigInteger('outcome_gold')->after('income_kegrum')->default(0);
            $table->bigInteger('outcome_uranium')->after('outcome_gold')->default(0);
            $table->bigInteger('outcome_food')->after('outcome_uranium')->default(0);
            $table->bigInteger('outcome_workforce')->after('outcome_food')->default(0);
            $table->bigInteger('outcome_kegrum')->after('outcome_workforce')->default(0);

            $table->bigInteger('balance_gold')->after('outcome_kegrum')->default(0);
            $table->bigInteger('balance_uranium')->after('balance_gold')->default(0);
            $table->bigInteger('balance_food')->after('balance_uranium')->default(0);
            $table->bigInteger('balance_workforce')->after('balance_food')->default(0);
            $table->bigInteger('balance_kegrum')->after('balance_workforce')->default(0);
            
            $table->bigInteger('energy_production')->after('balance_kegrum')->default(0);
            $table->bigInteger('energy_consumption')->after('energy_production')->default(0);
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
