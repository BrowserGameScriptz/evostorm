<?php

namespace App\Evostorm\Repositories;


interface MissionRepositoryInterface
{
    public function findUserMissions($user_id);
}