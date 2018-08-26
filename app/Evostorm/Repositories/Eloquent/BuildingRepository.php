<?php

namespace App\Evostorm\Repositories\Eloquent;


use App\Evostorm\Models\Building;
use App\Evostorm\Models\BuildingLevel;
use App\Evostorm\Models\BuildingQueue;
use App\Evostorm\Repositories\BuildingRepositoryInterface;
use Carbon\Carbon;

class BuildingRepository extends AbstractRepository implements BuildingRepositoryInterface
{
    public function __construct(Building $model)
    {
        $this->model = $model;
    }

    public function create(array $attributes = array())
    {
        return parent::getNew($attributes);
    }

    public function findIdByTileId($tile_id)
    {
        return $this->model->where('tile_id', $tile_id)->select('id')->first();
    }

    public function addBuildingToQueue(Building $building, BuildingLevel $buildingLevel)
    {
        $queue = new BuildingQueue();
        $queue->building_id = $building->id;
        $queue->finish_time = Carbon::now('Europe/Warsaw')->addMinutes($buildingLevel->cost->time);
        $queue->save();
    }

    public function findBuildingFirstLevelById($building_level_id)
    {
        return BuildingLevel::where('id', $building_level_id)->where('level', 1)->first();
    }


}