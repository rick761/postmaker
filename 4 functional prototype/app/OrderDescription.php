<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDescription extends Model
{
    //
    protected $fillable = ['text','order_id','title'];
}
