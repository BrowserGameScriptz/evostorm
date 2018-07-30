<?php

namespace App\Evostorm\Models;

use Illuminate\Database\Eloquent\Model;

class BuildingLevel extends Model {

    protected $table = 'building_levels';
    public $timestamps = false;

    public function type() {
        return $this->hasOne('App\Evostorm\ModelsBuildingType','id','building_type_id');
    }

}
