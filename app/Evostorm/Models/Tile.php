<?php

namespace App\Evostorm\Models;

use Illuminate\Database\Eloquent\Model;

class Tile extends Model {

    protected $table = 'tiles';
    public $timestamps = true;
    
    public function species() {
        return $this->hasOne('App\Evostorm\Models\Species', 'id', 'species_id');
    }
    
     public function tileType() {
        return $this->hasOne('App\Evostorm\Models\TileType', 'id', 'tile_type_id');
    }

}
