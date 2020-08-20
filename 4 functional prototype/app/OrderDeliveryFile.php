<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDeliveryFile extends Model
{
    //
    protected $fillable = ['text','user_id','order_delivery_id','url','is_invoice'];     
    // protected $guarded = [];    
    
    public function order_delivery()
    {
        return $this->belongsTo('App\OrderDelivery','order_delivery_id' );
    }
}
