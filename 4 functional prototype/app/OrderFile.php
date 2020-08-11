<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderFile extends Model
{
    //
    protected $fillable = ['url','order_id'];
    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}
