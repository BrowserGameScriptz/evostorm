<?php

namespace App\Evostorm\Models;

use Illuminate\Database\Eloquent\Model;

class BuildingWorker extends Model
{

    protected $table = 'buildings_workers';
    public $timestamps = true;

    public function species()
    {
        return $this->hasOne('App\Evostorm\Models\Species', 'id', 'species_id');
    }


}
