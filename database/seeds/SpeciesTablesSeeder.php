<?php

use Illuminate\Database\Seeder;
use App\Evostorm\Models\Species;
use App\Evostorm\Models\SpeciesGenome;

class SpeciesTablesSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        SpeciesGenome::create([
            'id' => 1,
            'user_id' => 1
        ]);

        Species::create([
            'id' => 1,
            'name' => 'Homus alibonus',
            'user_id' => 1,
            'genome_id' => 1,
            'strength' => 70,
            'endurance' => 54,
            'food_requirements' => 12,
            'reproduction' => 20,
            'death_rate' => 16,
            'intellect' => 15,
            'productivity' => 16
        ]);
    }

}
