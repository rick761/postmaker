<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserImage extends Model
{
    
    protected $hidden = [
        'created_at', 'updated_at','id', 'user_id',
    ];

    protected $fillable = [
        'url' 
    ]; 

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
