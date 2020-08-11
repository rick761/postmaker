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
  
             //fields
             $table->string('text');    
             $table->enum('style',['primary','succes','warning','error']);                 

  
             //extra       
             $table->foreign('order_delivery_id')->references('id')->on('order_deliveries');
             $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('order_delivery_comments',function (Blueprint $table) {
            $table->dropForeign(['order_delivery_id']);            
        });
        Schema::dropIfExists('order_delivery_id');
    }    
}
