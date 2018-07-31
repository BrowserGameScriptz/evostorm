<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Evostorm\Models\GameMap;
use App\Evostorm\Models\GameMapUserArea;
use App\Evostorm\Enums\GameConfigEnum;
use App\Evostorm\Models\GameConfig;
use App\Evostorm\Enums\TileTypeEnum;
use App\Evostorm\Enums\ResourcesEnum;

class GameMapSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::beginTransaction();

        // creating the actual map
        for ($x = 0; $x < GameConfig::find(GameConfigEnum::MAP_X_SIZE)->value; $x++) {
            for ($y = 0; $y < GameConfig::find(GameConfigEnum::MAP_Y_SIZE)->value; $y++) {

                $tile_id = $this->getRandomTerrainType();
                GameMap::create(
                        array(
                            "coord_x" => $x,
                            "coord_y" => $y,
                            "tile_type_id" => $tile_id,
                            "gold_left" => $this->getRandomResourcesByTypeAndTile(ResourcesEnum::GOLD, $tile_id),
                            "uranium_left" => $this->getRandomResourcesByTypeAndTile(ResourcesEnum::URANIUM, $tile_id),
                            "kegrum_left" => $this->getRandomResourcesByTypeAndTile(ResourcesEnum::KEGRUM, $tile_id)
                ));
            }
        }

        // creating the map user areas
        $user_map_width = GameConfig::find(GameConfigEnum::USER_MAP_WIDTH)->value;
        $user_map_height = GameConfig::find(GameConfigEnum::USER_MAP_HEIGHT)->value;
        for ($x = 0; $x <= GameConfig::find(GameConfigEnum::MAP_X_SIZE)->value - $user_map_width; $x += $user_map_width) {
            for ($y = 0; $y <= GameConfig::find(GameConfigEnum::MAP_Y_SIZE)->value - $user_map_height; $y += $user_map_width) {
                GameMapUserArea::create(array("starting_coord_x" => $x, "starting_coord_y" => $y));
            }
        }

        DB::commit();
    }

    public function getRandomTerrainType() {
        $tile_rand = rand(1, 18);
        $tile_id = TileTypeEnum::PLAIN;
        if ($tile_rand >= 11 && $tile_rand <= 12) {
            $tile_id = TileTypeEnum::FOREST;
        } else if ($tile_rand >= 13 && $tile_rand <= 14) {
            $tile_id = TileTypeEnum::MOUNTAINS;
        } else if ($tile_rand >= 15 && $tile_rand <= 16) {
            $tile_id = TileTypeEnum::WATER;
        } else if ($tile_rand >= 17 && $tile_rand <= 18) {
            $tile_id = TileTypeEnum::HILLS;
        }

        return $tile_id;
    }

    public function getRandomResourcesByTypeAndTile($resource, $tile_type) {
        switch ($tile_type) {
            case TileTypeEnum::PLAIN: {
                    if ($resource == ResourcesEnum::GOLD) {
                        return rand(1500, 2500);
                    } else if ($resource == ResourcesEnum::URANIUM) {
                        return rand(300, 900);
                    } else if ($resource == ResourcesEnum::KEGRUM) {
                        return rand(200, 500);
                    }
                }
                break;
            case TileTypeEnum::FOREST: {
                    if ($resource == ResourcesEnum::GOLD) {
                        return rand(1500, 2500);
                    } else if ($resource == ResourcesEnum::URANIUM) {
                        return rand(300, 900);
                    } else if ($resource == ResourcesEnum::KEGRUM) {
                        return rand(200, 500);
                    }
                }
                break;
            case TileTypeEnum::MOUNTAINS: {
                    if ($resource == ResourcesEnum::GOLD) {
                        return rand(3000, 25000);
                    } else if ($resource == ResourcesEnum::URANIUM) {
                        return rand(3000, 20000);
                    } else if ($resource == ResourcesEnum::KEGRUM) {
                        return rand(200, 500);
                    }
                }
                break;
            case TileTypeEnum::HILLS: {
                    if ($resource == ResourcesEnum::GOLD) {
                        return rand(1500, 2500);
                    } else if ($resource == ResourcesEnum::URANIUM) {
                        return rand(300, 900);
                    } else if ($resource == ResourcesEnum::KEGRUM) {
                        return rand(2000, 10000);
                    }
                }
                break;
            case TileTypeEnum::WATER: {
                    if ($resource == ResourcesEnum::GOLD) {
                        return rand(1500, 2500);
                    } else if ($resource == ResourcesEnum::URANIUM) {
                        return rand(1000, 5000);
                    } else if ($resource == ResourcesEnum::KEGRUM) {
                        return rand(200, 500);
                    }
                }
                break;
        }
    }

}
