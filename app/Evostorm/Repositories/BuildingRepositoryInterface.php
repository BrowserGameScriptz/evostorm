<?php

namespace App\Evostorm\Repositories;


interface BuildingRepositoryInterface
{
    public function findIdByTileId($tile_id);
}