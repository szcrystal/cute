<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    protected $fillable = [
		'name',
        'file',
        'second'
	];
}
