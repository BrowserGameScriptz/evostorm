<?php

namespace App\Evostorm\Facades\Contracts;


use App\Evostorm\Models\Cost;
use App\Evostorm\Models\User;

interface ResourcesFacadeInterface
{
    public function assignStartingResources(User $user);

    public function updateUserResourcesByCost(User $user, Cost $cost);
}