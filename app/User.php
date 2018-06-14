<?php

namespace App;

use Illuminate\Notifications\Notifiable;
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
        'name', 'email', 'password','avatar_patch','confirmation_token','confirmed'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email', 
    ];


    protected $cast = ['confirmed'=> 'boolean'];


    public function getRouteKeyName(){
        return 'name';
    }

    public function threads(){
        return $this->hasMany('App\Thread')->latest();
    }

    public function isAdmin(){
        return in_array($this->name, ['Bas']);
    }

    public function activity(){
        return $this->hasMany('App\Activity');
    }

    public function lastReply(){
        return $this->hasOne('App\Reply')->latest();
    }

    public function getAvatarPatchAttribute($avatar){
        if($avatar){
            return '/storage/'.$avatar;
        }else{
            return '/storage/avatars/avatar-placeholder.png';
        };
    }


}
