<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
      
    protected $keyType = 'string'; 
    public $incrementing = false;
    protected $guarded = ['created_at'];
    protected $hidden = ['updated_at'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            $post->{$post->getKeyName()} = (string) Str::uuid();
        });
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function postmaker()
    {
        return $this->belongsTo('App\User');
    }

    public function order_descriptions(){
        return $this->hasMany('App\OrderDescription');
    }

    public function order_requests(){
        return $this->hasMany('App\OrderRequest');
    }

    public function order_files(){
        return $this->hasMany('App\OrderFile');
    }

    public function order_tags(){
        return $this->hasMany('App\OrderTag');
    }

    public function order_deliveries(){
        return $this->hasMany('App\OrderDelivery');
    }
    
    public function order_messages(){
        return $this->hasMany('App\OrderMessage');
    }


    
    
}
