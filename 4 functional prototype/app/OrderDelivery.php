<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDelivery extends Model
{
    protected $fillable = ['text','title','order_id','type','rate'];     
    protected $guarded = [];
    protected $table = 'order_deliveries';
    
    public function order()
    {
        return $this->belongsTo('App\Order');
    }
    public function order_delivery_files()
    {
        return $this->hasMany('App\OrderDeliveryFile');
    }
    public function order_delivery_comments()
    {
        return $this->hasMany('App\OrderDeliveryComment');
    }
}
