<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TwAccount extends Model
{
    protected $fillable = [
    	'model_id',
        'name',
        'pass',
        'consumer_key',
        'consumer_secret',
        'access_token',
        'access_token_secret',
    ];
}

