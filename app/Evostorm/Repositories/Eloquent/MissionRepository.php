<?php

namespace App\Evostorm\Repositories\Eloquent;


use App\Evostorm\Repositories\MissionRepositoryInterface;
use App\Evostorm\Models\Mission;

class MissionRepository extends AbstractRepository implements MissionRepositoryInterface
{
    public function __construct(Mission $model)
    {
        $this->model = $model;
    }


    public function findUserMissions($user_id)
    {
        return $this->model->where('user_id', $user_id)->get();
    }

}