<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserShowDelivery extends Model
{    
    protected $fillable = ['order_delivery_file_id'];   

    public function order_delivery_file()
    {
        return $this->belongsTo('App\OrderDeliveryFile');
    }
}
