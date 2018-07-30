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

}