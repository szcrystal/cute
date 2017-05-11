<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
    	'model_id',
        //'del_status',
        'cate_id',
        'movie_id',
        'title',
        'sub_title',
        'slug',
        'area_info',
        'post_thumb',
        'basic_info',
        'open_status',
        'open_date',
        'yt_up',
        'sns_up',
        'view_count',
    
    ];
    
    
}


