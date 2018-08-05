<?php

namespace App\Evostorm\Facades\Contracts;


use App\Evostorm\Models\User;

interface ResourcesFacadeInterface
{
    public function assignStartingResources(User $user);
}