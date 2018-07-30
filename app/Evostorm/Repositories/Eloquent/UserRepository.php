<?php

namespace App\Evostorm\Repositories\Eloquent;


use App\Evostorm\Models\User;
use App\Evostorm\Repositories\UserRepositoryInterface;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }
}