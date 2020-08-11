<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderTag extends Model
{
    protected $fillable = ['text','order_id'];     
    protected $guarded = [];
    
    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}
