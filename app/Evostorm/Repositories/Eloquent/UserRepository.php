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

    public function create(array $data)
    {
        $user = $this->getNew();
        if (isset($data['id'])) {
            $user->id = $data['id'];
        }
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);

        $user->save();
        return $user;
    }


}