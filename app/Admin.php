<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $fillable = [
        'name',
        'nick_name',
        'email',
        'password',
    
    	'model_thumb',
        'school',
        'charm_point',
        'hobby',
    
        'authority',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

}

