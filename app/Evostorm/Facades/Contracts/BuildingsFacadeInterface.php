<?php

namespace App\Evostorm\Facades\Contracts;


use App\Evostorm\Models\BuildingLevel;
use App\Evostorm\Models\Tile;
use App\Evostorm\Models\User;

interface BuildingsFacadeInterface
{
    public function checkEnoughResourcesToBuild(BuildingLevel $buildingLevel, User $user);

    public function checkBuildingAllowedToBuildOnTile(BuildingLevel $buildingLevel, Tile $tile);
}