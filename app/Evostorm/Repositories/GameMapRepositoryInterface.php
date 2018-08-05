<?php

namespace App\Evostorm\Repositories;


interface GameMapRepositoryInterface
{
    public function findListByUserId($user_id);

    public function findByIdAndUserId($id, $user_id);
}