<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryItem extends Model
{
    protected $fillable = [
    	'cate_id',
        'item_num',
    	'title',
        'second',
    ];

}
