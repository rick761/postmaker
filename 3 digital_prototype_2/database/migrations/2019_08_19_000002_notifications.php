<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Notifications extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            //keys
            $table->id();
            $table->uuid('user_id');    

            //fields
            $table->string('text');                   
            $table->string('url');    
            $table->boolean('read')->default(0); 

            //extra
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('notifications',function (Blueprint $table) {
            $table->dropForeign(['user_id']);            
        });
        Schema::dropIfExists('notifications');
    }
}
