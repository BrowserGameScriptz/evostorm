<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Evostorm\Models\GameMap;
use App\Evostorm\Enums\NativeSpeciesEnum;
use App\Evostorm\Enums\TileTypeEnum;
use Illuminate\Support\Facades\Log;

class GameMapSpeciesSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::beginTransaction();

        GameMap::where('tile_type_id', '<>', TileTypeEnum::WATER)->chunk(1000, function($tiles) {
            foreach ($tiles as $tile) {
                $tile->species_id = NativeSpeciesEnum::HOMUS_ALIBONUS;
                $tile->species_amount = $this->getRandomSpeciesAmount($tile->tile_type_id);
                if (!$tile->save()) {
                    DB::rollback();
                    Log::error("There was an error during game map species initialization.");
                }
            }
        });

        DB::commit();
    }

    public function getRandomSpeciesAmount($tile_type_id) {
        switch ($tile_type_id) {
            case TileTypeEnum::PLAIN: {
                    return rand(4, 500);
                }
                break;
            case TileTypeEnum::FOREST: {
                    return rand(4, 200);
                }
                break;
            case TileTypeEnum::MOUNTAINS: {
                    return rand(4, 100);
                }
                break;
            case TileTypeEnum::HILLS: {
                    return rand(4, 300);
                }
                break;
        }
    }

}
