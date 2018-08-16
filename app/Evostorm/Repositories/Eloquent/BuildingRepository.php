<?php

namespace App\Evostorm\Repositories\Eloquent;


use App\Evostorm\Models\Building;
use App\Evostorm\Repositories\BuildingRepositoryInterface;

class BuildingRepository extends AbstractRepository implements BuildingRepositoryInterface
{
    public function __construct(Building $model)
    {
        $this->model = $model;
    }

    public function findIdByTileId($tile_id)
    {
        return $this->model->where('tile_id', $tile_id)->select('id')->first();
    }


}