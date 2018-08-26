<?php

namespace App\Evostorm\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Evostorm\Models\Cost;

class User extends Authenticatable
{

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Check if user has more resources than cost required
     * @param \App\Evostorm\Models\Cost $cost
     * @return bool
     */
    public function canAfford(Cost $cost)
    {
        if ((($this->amount_gold - $cost->gold) < 0) || (($this->amount_uranium - $cost->uranium) < 0) || (($this->amount_kegrum - $cost->kegrum) < 0)
        ) {
            return false;
        } else {
            return true;
        }
    }

}
