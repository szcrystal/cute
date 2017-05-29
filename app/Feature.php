<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable = [
    	'title',
        'address',
        'slug',
        'movie_path',
        'thumb_path',
        'contents',
        'open_status',
        'view_count',
    ];
}
