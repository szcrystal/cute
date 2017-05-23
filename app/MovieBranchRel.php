<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovieBranchRel extends Model
{
    protected $fillable = [
    	'model_id',
        'cate_id',
        //'music_id',
        //'filter_id',
        'memo',
        'folder_name',
        'area_info',
        'combine_status',
        'complete',
    ];

}
