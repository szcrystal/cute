<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelSnap extends Model
{
    protected $fillable = [
    	'model_id',
    	'snap_path',
        'ask',
        'answer',
        'number',
    ];

    
}
