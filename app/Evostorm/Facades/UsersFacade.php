<?php

namespace App\Evostorm\Facades;


use App\Evostorm\Facades\Contracts\UsersFacadeInterface;
use App\Evostorm\Models\Cost;
use App\Evostorm\Models\User;

class UsersFacade implements UsersFacadeInterface
{
    public function checkHasEnoughResources(User $user, Cost $cost)
    {
        if ((($user->amount_gold - $cost->gold) < 0) || (($user->amount_uranium - $cost->uranium) < 0) || (($user->amount_kegrum - $cost->kegrum) < 0)
        ) {
            return false;
        } else {
            return true;
        }
    }

}