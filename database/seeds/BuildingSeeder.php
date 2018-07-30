<?php

use Illuminate\Database\Seeder;
use App\Models\BuildingType;
use App\Models\BuildingStatus;

class BuildingSeeder extends Seeder {

    public function run() {
        BuildingType::create(array("id" => 1, "short_name" => 'GOLD_MINE', "name" => 'Gold mine'));
        BuildingType::create(array("id" => 2, "short_name" => 'KEGRUM_MINE', "name" => 'Kegrum mine'));
        BuildingType::create(array("id" => 3, "short_name" => 'URANIUM_MINE', "name" => 'Uranium mine'));
        BuildingType::create(array("id" => 4, "short_name" => 'LABORATORY', "name" => 'Laboratory'));
        BuildingType::create(array("id" => 5, "short_name" => 'WORKFORCE_PRODUCTION_FACILITY', "name" => 'Workforce production facility'));
        BuildingType::create(array("id" => 6, "short_name" => 'MACHINE_FACTORY', "name" => 'Machine factory'));
        BuildingType::create(array("id" => 7, "short_name" => 'SPACESHIP_FACTORY', "name" => 'Spaceship factory'));
        BuildingType::create(array("id" => 8, "short_name" => 'FOOD_FARM', "name" => 'Food farm'));
        BuildingType::create(array("id" => 9, "short_name" => 'MARKET', "name" => 'Market'));
        BuildingType::create(array("id" => 10, "short_name" => 'SPACESHIP_HARBOR', "name" => 'Spaceship harbor'));
        BuildingType::create(array("id" => 11, "short_name" => 'ENERGY_PRODUCTION_FACILITY', "name" => 'Energy production facility'));

        BuildingStatus::create(array("id" => 1, "short_name" => 'BUILDING_IN_PROGRESS', "name" => 'Building in progress'));
        BuildingStatus::create(array("id" => 2, "short_name" => 'OPERATIONAL', "name" => 'Operational'));
        BuildingStatus::create(array("id" => 3, "short_name" => 'NON-OPERATIONAL', "name" => 'Non-operational'));
        BuildingStatus::create(array("id" => 4, "short_name" => 'UPGRADE_IN_PROGRESS', "name" => 'Upgrade in progress'));
        BuildingStatus::create(array("id" => 5, "short_name" => 'DEMOLITION_IN_PROGRESS', "name" => 'Demolition in progress'));
    }

}
