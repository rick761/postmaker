<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserImages extends Model
{
    //
    protected $hidden = [
        'created_at', 'updated_at','id', 'user_id',
    ];
}
