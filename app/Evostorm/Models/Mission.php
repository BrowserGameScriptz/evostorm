<?php

namespace App\Evostorm\Models;

use Illuminate\Database\Eloquent\Model;

class Mission extends Model {

    protected $table = 'missions';
    public $timestamps = true;

    public function status() {
        return $this->hasOne('App\Evostorm\Models\MissionStatus', 'id', 'mission_status_id');
    }

    public function type() {
        return $this->hasOne('App\Evostorm\Models\MissionType', 'id', 'mission_type_id');
    }

}
