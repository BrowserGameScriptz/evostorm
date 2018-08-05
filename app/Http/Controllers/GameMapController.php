<?php

namespace App\Http\Controllers;

use App\Evostorm\Repositories\GameConfigRepositoryInterface;
use App\Evostorm\Repositories\GameMapRepositoryInterface;
use App\Evostorm\Enums\GameConfigEnum;
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
    private $gameConfigRepository;

    /**
     * GameMapController constructor.
     * @param $gameMapRepository
     */
    public function __construct(GameMapRepositoryInterface $gameMapRepository,
                                GameConfigRepositoryInterface $gameConfigRepository)
    {
        $this->gameMapRepository = $gameMapRepository;
        $this->gameConfigRepository = $gameConfigRepository;
    }


    public function getUserMap()
    {

        $tiles = $this->gameMapRepository->findListByUserId(Auth::user()->id);

        return response()->json([
            'user_map_width' => $this->gameConfigRepository->findById(GameConfigEnum::USER_MAP_WIDTH)->value,
            'user_map_height' => $this->gameConfigRepository->findById(GameConfigEnum::USER_MAP_HEIGHT)->value,
            'user_map_tile_radius' => $this->gameConfigRepository->findById(GameConfigEnum::USER_MAP_TILE_RADIUS)->value,
            'tiles' => $tiles
        ]);
    }

}
