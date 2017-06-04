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
        'state_id',
        'title',
        //'sub_title',
        'slug',
        'address',
        'thumb_path',
        'movie_path',
        'contents',
        'open_status',
        'open_date',
        'feature',
    
    	'yt_id',
        'yt_description',
    
        'yt_up',
        'tw_up',
        'fb_up',
        'view_count',
    
    ];
    
    
}


