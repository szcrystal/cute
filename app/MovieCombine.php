<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovieCombine extends Model
{
    protected $fillable = [
    	'model_id',
        'cate_id',
        'rel_id',
        'music_id',
        'filter_id',
    
        'movie_path',
        'movie_thumb',
        'area',
        'title',
        'atcl_status',
        
        'open_status',
        'yt_up',
        'sns_up',
    ];
}
