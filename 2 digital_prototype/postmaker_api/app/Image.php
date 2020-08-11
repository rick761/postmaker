<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{    
    protected $fillable = ['url','order_id'];
    protected $hidden = ['order_id','created_at', 'updated_at'];

    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}
