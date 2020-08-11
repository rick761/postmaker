<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrderMessages extends Migration
{
    public function up()
    {
        Schema::create('order_messages', function (Blueprint $table) {      

            //key
            $table->id();
            $table->uuid('user_id')->nullable();
            $table->uuid('order_id');  

            //fields
            $table->string('text')->nullable();
            $table->string('url')->nullable();     

            //extra            
            $table->foreign('user_id')->references('id')->on('users');       
            $table->foreign('order_id')->references('id')->on('orders');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('order_messages',function (Blueprint $table) {
            $table->dropForeign(['user_id']); 
            $table->dropForeign(['order_id']);             
        });
        Schema::dropIfExists('order_messages');
    }    
}
