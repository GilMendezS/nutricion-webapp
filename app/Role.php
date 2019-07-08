<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const NUTRIOLOGIST = 1;
    const PATIENT = 2;
    protected $table = 'roles';
    public function users(){
        return $this->belongsToMany(User::class);
    }
}
