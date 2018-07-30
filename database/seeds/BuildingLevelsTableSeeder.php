<?php

use Illuminate\Database\Seeder;
use App\Models\BuildingLevel;
use App\Enums\BuildingTypeEnum;

class BuildingLevelsTableSeeder extends Seeder {

    protected function createBuildingLevel($id, $building_type_id, $level, $gold_cost, $uranium_cost, $kegrum_cost, $base_gold_production, $base_uranium_production, $base_kegrum_production, $base_gold_upkeep, $base_uranium_upkeep, $base_kegrum_upkeep, $base_energy_consumption, $base_energy_production, $min_workers_amount, $max_workers_amount, $build_time) {
        BuildingLevel::create(array(
            'id' => $id,
            'building_type_id' => $building_type_id,
            'level' => $level,
            'gold_cost' => $gold_cost,
            'uranium_cost' => $uranium_cost,
            'kegrum_cost' => $kegrum_cost,
            'base_gold_production' => $base_gold_production,
            'base_uranium_production' => $base_uranium_production,
            'base_kegrum_production' => $base_kegrum_production,
            'base_gold_upkeep' => $base_gold_upkeep,
            'base_uranium_upkeep' => $base_uranium_upkeep,
            'base_kegrum_upkeep' => $base_kegrum_upkeep,
            'base_energy_consumption' => $base_energy_consumption,
            'base_energy_production' => $base_energy_production,
            'min_workers_amount' => $min_workers_amount,
            'max_workers_amount' => $max_workers_amount,
            'build_time' => $build_time
        ));
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // Gold mine buildings
        $this->createBuildingLevel(1, BuildingTypeEnum::GOLD_MINE, 1, 300, 50, 500, 10, 0, 0, 0, 0, 0, 20, 0, 20, 100, 5);
        $this->createBuildingLevel(2, BuildingTypeEnum::GOLD_MINE, 2, 400, 100, 700, 15, 0, 0, 0, 0, 0, 40, 0, 30, 120, 30);
        $this->createBuildingLevel(3, BuildingTypeEnum::GOLD_MINE, 3, 600, 200, 700, 25, 0, 0, 0, 0, 0, 80, 0, 40, 150, 120);

        // Energy production facilities
        $this->createBuildingLevel(101, BuildingTypeEnum::ENERGY_PRODUCTION_FACILITY, 1, 250, 200, 400, 0, 0, 0, 5, 20, 0, 0, 300, 10, 30, 10);
    }

}
