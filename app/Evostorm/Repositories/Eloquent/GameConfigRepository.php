<?php

namespace App\Evostorm\Repositories\Eloquent;


use App\Evostorm\Models\GameConfig;
use App\Evostorm\Repositories\GameConfigRepositoryInterface;

class GameConfigRepository extends AbstractRepository implements GameConfigRepositoryInterface
{
    public function __construct(GameConfig $model)
    {
        $this->model = $model;
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }


}