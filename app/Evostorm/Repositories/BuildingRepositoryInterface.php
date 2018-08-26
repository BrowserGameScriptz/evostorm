<?php

namespace App\Evostorm\Repositories;


use App\Evostorm\Models\Building;
use App\Evostorm\Models\BuildingLevel;

interface BuildingRepositoryInterface
{
    public function create(array $attributes);

    public function findIdByTileId($tile_id);

    public function addBuildingToQueue(Building $building, BuildingLevel $buildingLevel);

    public function findBuildingFirstLevelById($building_level_id);
}