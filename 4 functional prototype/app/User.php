<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;      

    protected $keyType = 'string'; 

    public $incrementing = false;
  
    protected $fillable = [
        'first_name','last_name','email', 'password', 'type', 'display_name', 'phone', 'avatar','description'
    ]; 

    protected $hidden = [
        'password', 'remember_token', 'first_name', 'last_name', 'phone'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ]; 

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            $post->{$post->getKeyName()} = (string) Str::uuid();
        });
    }

    public function user_images()
    {
        return $this->hasMany('App\UserImage');
    }

    public function orders(){
        return $this->hasMany('App\Order');
    }

    public function user_likes(){
        return $this->hasMany('App\UserLike', 'user_id');
    }

    public function user_show_deliverys(){
        return $this->hasMany('App\UserShowDelivery');
    }


}
