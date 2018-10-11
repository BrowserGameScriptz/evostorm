<?php

namespace App\Evostorm\Traits;


use App\Evostorm\Models\Tile;
use App\Evostorm\Models\User;
use Auth;
use App\Evostorm\Exceptions\Tile\UserTileNotFoundException;

trait ChecksTileExists
{

    public function checkUserTileExists($tile_id, User $user): Tile
    {
        $tile = $this->tileRepository->findByIdAndUserId($tile_id, $user->id);
        if (!$tile) {
            throw new UserTileNotFoundException();
        }

        return $tile;
    }
}