<?php

namespace App\Evostorm\Repositories;


use App\Evostorm\Models\Tile;

interface TileRepositoryInterface
{
    public function findListByUserId($user_id);

    public function findByIdAndUserId($id, $user_id);

}