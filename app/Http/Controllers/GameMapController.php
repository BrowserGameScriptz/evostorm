<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Evostorm\Enums\GameConfigEnum;
use App\Evostorm\Models\GameConfig;
use App\Evostorm\Models\GameMap;
use DB;
use Auth;

/**
 * Description of GameMapController
 *
 * @author damian
 */
class GameMapController extends Controller {

    public function getUserMap() {

        $tiles = DB::select(DB::raw(
                                "SELECT gm.id AS `id`, gm.coord_x AS `coord_x`, gm.coord_y AS `coord_y`, gm.tile_type_id AS `tile_type_id`, b.building_level_id AS `building_level_id`, b.building_status_id AS `building_status_id`
FROM game_map gm
LEFT JOIN buildings b ON b.game_map_id=gm.id
WHERE gm.user_id=:user_id ORDER BY gm.id ASC;"), array('user_id' => Auth::user()->id));

        return response()->json([
                    'user_map_width' => GameConfig::find(GameConfigEnum::USER_MAP_WIDTH)->value,
                    'user_map_height' => GameConfig::find(GameConfigEnum::USER_MAP_HEIGHT)->value,
                    'user_map_tile_radius' => GameConfig::find(GameConfigEnum::USER_MAP_TILE_RADIUS)->value,
                    'tiles' => $tiles
        ]);
    }

}
