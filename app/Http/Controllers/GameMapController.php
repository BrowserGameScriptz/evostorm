<?php

namespace App\Http\Controllers;

use App\Evostorm\Repositories\GameMapRepositoryInterface;
use Illuminate\Http\Request;
use App\Evostorm\Enums\GameConfigEnum;
use App\Evostorm\Models\GameConfig;
use DB;
use Auth;

/**
 * Description of GameMapController
 *
 * @author damian
 */
class GameMapController extends Controller
{

    private $gameMapRepository;

    /**
     * GameMapController constructor.
     * @param $gameMapRepository
     */
    public function __construct(GameMapRepositoryInterface $gameMapRepository)
    {
        $this->gameMapRepository = $gameMapRepository;
    }


    public function getUserMap()
    {

        $tiles = $this->gameMapRepository->getUserGameMapTiles(Auth::user()->id);

        return response()->json([
            'user_map_width' => GameConfig::find(GameConfigEnum::USER_MAP_WIDTH)->value,
            'user_map_height' => GameConfig::find(GameConfigEnum::USER_MAP_HEIGHT)->value,
            'user_map_tile_radius' => GameConfig::find(GameConfigEnum::USER_MAP_TILE_RADIUS)->value,
            'tiles' => $tiles
        ]);
    }

}
