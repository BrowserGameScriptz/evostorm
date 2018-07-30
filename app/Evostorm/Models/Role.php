<?php

namespace App\Evostorm\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of Role
 *
 * @author damian
 */
class Role extends Model {

    protected $table = 'roles';
    public $timestamps = false;

    public function users() {
        return $this->belongsToMany('App\Evostorm\Models\User', 'user_roles');
    }

}
