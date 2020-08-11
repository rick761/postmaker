<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserImages extends Migration
{  
    public function up()
    {
        Schema::create('user_images', function (Blueprint $table) {
            //keys
            $table->id();
            $table->uuid('user_id');    

            //fields
            $table->string('url');                   

            //extra
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('user_images',function (Blueprint $table) {
            $table->dropForeign(['user_id']);            
        });
        Schema::dropIfExists('user_images');
    }
}
