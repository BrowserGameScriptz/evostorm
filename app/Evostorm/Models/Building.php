<?php

namespace App\Evostorm\Models;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{

    protected $table = 'buildings';
    public $timestamps = true;

    public function level()
    {
        return $this->hasOne('App\Evostorm\Models\BuildingLevel', 'id', 'building_level_id');
    }

    public function tile()
    {
        return $this->hasOne('App\Evostorm\Models\Tile', 'id', 'tile_id');
    }

    public function status()
    {
        return $this->hasOne('App\Evostorm\Models\BuildingStatus', 'id', 'building_status_id');
    }

}
