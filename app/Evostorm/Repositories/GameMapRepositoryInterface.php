<?php

namespace App\Evostorm\Repositories;


interface GameMapRepositoryInterface
{
    public function getUserGameMapTiles($user_id);
}