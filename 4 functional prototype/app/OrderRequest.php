<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderRequest extends Model
{  
     protected $fillable = ['payment','text','order_id','postmaker_id'];
     
     public function postmaker()
     {
         return $this->belongsTo('App\User');
     }

     public function order()
     {
         return $this->belongsTo('App\Order');
     }
}
