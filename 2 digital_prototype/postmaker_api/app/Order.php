<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $hidden = [
        //'postmaker_id', 'user_id'
    ];    

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function postmaker()
    {
        return $this->belongsTo('App\User');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function images()
    {
        return $this->hasMany('App\Image');
    }

    public function requests()
    {
        return $this->hasMany('App\Request');
    }

    public function deliverys()
    {
        return $this->hasMany('App\Delivery');
    }

    public function messages()
    {
        return $this->hasMany('App\Message');
    }

}
