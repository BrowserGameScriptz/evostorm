<?php

namespace App\Evostorm\Facades\Contracts;


use App\Evostorm\Models\Cost;
use App\Evostorm\Models\User;

interface UsersFacadeInterface
{
    public function checkHasEnoughResources(User $user, Cost $cost);
}