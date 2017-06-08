<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeatureCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'status',
    ];
}

