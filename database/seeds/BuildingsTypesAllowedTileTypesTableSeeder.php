<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums;

class BuildingsTypesAllowedTileTypesTableSeeder extends Seeder {

    protected function runInsert($buildingType, $tileType) {
        DB::table('building_types_allowed_tile_types')
                ->insert(array(
                    'building_type_id' => $buildingType,
                    'tile_type_id' => $tileType
        ));
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->runInsert(Enums\BuildingTypeEnum::GOLD_MINE, Enums\TileTypeEnum::PLAIN);
        $this->runInsert(Enums\BuildingTypeEnum::GOLD_MINE, Enums\TileTypeEnum::FOREST);
        $this->runInsert(Enums\BuildingTypeEnum::GOLD_MINE, Enums\TileTypeEnum::MOUNTAINS);
        $this->runInsert(Enums\BuildingTypeEnum::GOLD_MINE, Enums\TileTypeEnum::HILLS);

        $this->runInsert(Enums\BuildingTypeEnum::KEGRUM_MINE, Enums\TileTypeEnum::PLAIN);
        $this->runInsert(Enums\BuildingTypeEnum::KEGRUM_MINE, Enums\TileTypeEnum::FOREST);
        $this->runInsert(Enums\BuildingTypeEnum::KEGRUM_MINE, Enums\TileTypeEnum::MOUNTAINS);
        $this->runInsert(Enums\BuildingTypeEnum::KEGRUM_MINE, Enums\TileTypeEnum::HILLS);

        $this->runInsert(Enums\BuildingTypeEnum::URANIUM_MINE, Enums\TileTypeEnum::PLAIN);
        $this->runInsert(Enums\BuildingTypeEnum::URANIUM_MINE, Enums\TileTypeEnum::FOREST);
        $this->runInsert(Enums\BuildingTypeEnum::URANIUM_MINE, Enums\TileTypeEnum::MOUNTAINS);
        $this->runInsert(Enums\BuildingTypeEnum::URANIUM_MINE, Enums\TileTypeEnum::HILLS);

        $this->runInsert(Enums\BuildingTypeEnum::LABORATORY, Enums\TileTypeEnum::PLAIN);
        $this->runInsert(Enums\BuildingTypeEnum::LABORATORY, Enums\TileTypeEnum::FOREST);
        $this->runInsert(Enums\BuildingTypeEnum::LABORATORY, Enums\TileTypeEnum::HILLS);

        $this->runInsert(Enums\BuildingTypeEnum::WORKFORCE_PRODUCTION_FACILITY, Enums\TileTypeEnum::PLAIN);
        $this->runInsert(Enums\BuildingTypeEnum::WORKFORCE_PRODUCTION_FACILITY, Enums\TileTypeEnum::FOREST);
        $this->runInsert(Enums\BuildingTypeEnum::WORKFORCE_PRODUCTION_FACILITY, Enums\TileTypeEnum::HILLS);

        $this->runInsert(Enums\BuildingTypeEnum::MACHINE_FACTORY, Enums\TileTypeEnum::PLAIN);
        $this->runInsert(Enums\BuildingTypeEnum::MACHINE_FACTORY, Enums\TileTypeEnum::FOREST);
        $this->runInsert(Enums\BuildingTypeEnum::MACHINE_FACTORY, Enums\TileTypeEnum::HILLS);

        $this->runInsert(Enums\BuildingTypeEnum::SPACESHIP_FACTORY, Enums\TileTypeEnum::PLAIN);
        $this->runInsert(Enums\BuildingTypeEnum::SPACESHIP_FACTORY, Enums\TileTypeEnum::FOREST);
        $this->runInsert(Enums\BuildingTypeEnum::SPACESHIP_FACTORY, Enums\TileTypeEnum::HILLS);

        $this->runInsert(Enums\BuildingTypeEnum::FOOD_FARM, Enums\TileTypeEnum::PLAIN);

        $this->runInsert(Enums\BuildingTypeEnum::MARKET, Enums\TileTypeEnum::PLAIN);
        $this->runInsert(Enums\BuildingTypeEnum::MARKET, Enums\TileTypeEnum::FOREST);
        $this->runInsert(Enums\BuildingTypeEnum::MARKET, Enums\TileTypeEnum::HILLS);

        $this->runInsert(Enums\BuildingTypeEnum::SPACESHIP_HARBOR, Enums\TileTypeEnum::PLAIN);

        $this->runInsert(Enums\BuildingTypeEnum::ENERGY_PRODUCTION_FACILITY, Enums\TileTypeEnum::PLAIN);
        $this->runInsert(Enums\BuildingTypeEnum::ENERGY_PRODUCTION_FACILITY, Enums\TileTypeEnum::FOREST);
        $this->runInsert(Enums\BuildingTypeEnum::ENERGY_PRODUCTION_FACILITY, Enums\TileTypeEnum::HILLS);
    }

}
