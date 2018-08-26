<?php

namespace App\Evostorm\Facades\Contracts;


use App\Evostorm\Models\Tile;
use App\Evostorm\Models\User;

interface TilesFacadeInterface
{
    public function assignRandomTerrain(User $user);

    public function erasePopulation(Tile $tile);
}