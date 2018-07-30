<?php

namespace App\Evostorm\Models;

use Illuminate\Database\Eloquent\Model;

class GameMap extends Model {

    protected $table = 'game_map';
    public $timestamps = true;
    
    public function species() {
        return $this->hasOne('App\Evostorm\Models\Species', 'id', 'species_id');
    }
    
     public function tileType() {
        return $this->hasOne('App\Evostorm\Models\TileType', 'id', 'tile_type_id');
    }

}
