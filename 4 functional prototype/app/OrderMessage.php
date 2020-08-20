<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderMessage extends Model
{
    //
    protected $fillable = ['user_id','text','url'];
}
