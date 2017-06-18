<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
    	'all_area',
        'name',
        'email',
        'mail_header',
        'mail_footer',
        'snap_count',
        'item_count',
    ];
}
