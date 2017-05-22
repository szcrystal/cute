<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovieBranch extends Model
{
    protected $fillable = [
    	'rel_id',
    	'title',
        'second',
        'org_name',
        'duration',
        'movie_path',
        'sub_text',
        'number',
    ];
}

