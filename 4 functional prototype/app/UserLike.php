<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLike extends Model
{    
    protected $fillable = ['liker_id','order_id'];

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    public function liker()
    {
        return $this->belongsTo('App\User','liker_id');
    }
}
