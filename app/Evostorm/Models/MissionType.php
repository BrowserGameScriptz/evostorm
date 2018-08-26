<?php

namespace App\Evostorm\Models;

use Illuminate\Database\Eloquent\Model;

class MissionType extends Model
{

    protected $table = 'mission_types';
    public $timestamps = false;

    public function cost()
    {
        return $this->hasOne('App\Evostorm\Models\Cost', 'id', 'cost_id');
    }
}
