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
    
    	'yt_id',
        'yt_description',
    
        'yt_up',
        'tw_up',
        'fb_up',
        'view_count',
    
    ];
    
    
}


