<?php

namespace App\Evostorm\Facades\Contracts;


use App\Evostorm\Models\User;

interface GameMapFacadeInterface
{
    public function assignRandomTerrain(User $user);
}