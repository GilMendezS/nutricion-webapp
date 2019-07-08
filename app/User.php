<?php

namespace App;

use App\Role;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getPacients(){
        return $this->hasMany(User::class, 'creator_id', 'id')->where('creator_id', $this->id);
    }
    public function becomesPatient(){
        return $this->roles()->attach(Role::PATIENT);
    }
    public function becomesNutrioligist(){
        return $this->roles()->attach(ROle::NUTRIOLOGIST);
    }
    public function hasRole($role){
        return in_array($role, $this->roles->pluck('id')->toArray());
    }
    public function removeRole($role){
        return $this->roles()->detach($role);
    }
    public function roles(){
        return $this->belongsToMany(Role::class);
    }
}
