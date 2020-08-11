<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'user_id','postmaker_id','text','order_id'
    ];

    //
    public function file()
    {
        return $this->belongsTo('App\File');
    }

    public function order()
    {
        return $this->belongsTo('App\Order');
    }
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
