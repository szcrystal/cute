<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
    	'model_id',
        //'del_status',
        'cate_id',
        'title',
        'sub_title',
        'slug',
        'area_info',
        'post_thumb',
        'open_status',
        'open_date',
        'view_count',
    
    ];
    
    
}


