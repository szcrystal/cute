<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
    	'askcate_id',
        'per_name',
    	'per_email',
        'age',
        'school',
        'tel_num',
    	'post_num',
        'address',
        'pic_1',
        'pic_2',
    	'context',
    ];

    

}
