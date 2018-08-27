<?php

namespace App\Evostorm\Repositories;


use App\Evostorm\Models\Building;
use App\Evostorm\Models\User;

interface BuildingRepositoryInterface
{
    public function create(array $attributes);

    public function findIdByTileId($tile_id);

    public function findUserBuildingsList(User $user);

    public function addBuildingToQueue(Building $building);

    public function findBuildingFirstLevelById($building_level_id);
}