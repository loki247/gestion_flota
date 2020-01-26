<?php

namespace App\Models\usuarios;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model{
    protected $table = 'usuarios.roles';
    protected $primaryKey = 'id_rol';

    public function users(){
        return $this->belongsToMany('App\User')->withTimestamps();
    }
}
