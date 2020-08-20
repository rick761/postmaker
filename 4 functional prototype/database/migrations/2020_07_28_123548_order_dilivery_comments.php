<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrderDiliveryComments extends Migration
{
    public function up()
    {
        Schema::create('order_delivery_comments', function (Blueprint $table) {
             //key
             $table->id();            
             $table->foreignId('order_delivery_id');  
             $table->uuid('user_id')->nullable();  

             //fields
             $table->string('text');       

             //extra       
             $table->foreign('order_delivery_id')->references('id')->on('order_deliveries');
             $table->foreign('user_id')->references('id')->on('users');
             $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('order_delivery_comments',function (Blueprint $table) {
            $table->dropForeign(['order_delivery_id']);            
            $table->dropForeign(['user_id']);            
        });
        Schema::dropIfExists('order_delivery_comments');
    }    
}
