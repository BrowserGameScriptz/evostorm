<?php

namespace App\Evostorm\Facades;

use App\Evostorm\Models\User;
use App\Evostorm\Models\GameMap;
use App\Evostorm\Models\GameMapUserArea;
use App\Evostorm\Models\GameConfig;
use App\Evostorm\Enums\GameConfigEnum;

class GameMapFacade {

    /**
     * This function assigns a random area of the game map to the user who
     * has just registered
     * @param User $user
     */
    public function assignRandomTerrain(User $user) {
        $gameMapUserArea = GameMapUserArea::where('is_used', false)->inRandomOrder()->first();
        $gameMapUserArea->user_id = $user->id;
        $gameMapUserArea->is_used = true;
        $gameMapUserArea->save();

        for ($x = $gameMapUserArea->starting_coord_x; $x < $gameMapUserArea->starting_coord_x + GameConfig::find(GameConfigEnum::USER_MAP_WIDTH)->value; $x++) {
            for ($y = $gameMapUserArea->starting_coord_y; $y < $gameMapUserArea->starting_coord_y + GameConfig::find(GameConfigEnum::USER_MAP_HEIGHT)->value; $y++) {
                $gm = GameMap::where('coord_x', $x)->where('coord_y', $y)->first();
                $gm->is_used = true;
                $gm->user_id = $user->id;

                $gm->save();
            }
        }
    }

}
