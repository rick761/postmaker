<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $table = 'deliverys';
    protected $hidden = [''];
    protected $fillable = ['title','file_id','order_id'];
    
    public function file()
    {
        return $this->belongsTo('App\File');
    }

    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}
