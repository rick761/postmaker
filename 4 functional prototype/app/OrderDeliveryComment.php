<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDeliveryComment extends Model
{
        //
        protected $fillable = ['user_id','text'];     
        // protected $guarded = [];    
        
        public function order_delivery()
        {
            return $this->belongsTo('App\OrderDelivery','order_delivery_id' );
        }
}
