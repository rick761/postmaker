<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrderDiliveries extends Migration
{
    public function up()
    {
        Schema::create('order_deliveries', function (Blueprint $table) {
            //key
           $table->id();            
           $table->uuid('order_id');  

           //fields
           $table->string('title');   
           $table->string('text');   
           $table->enum('type',['pre','final'])->default('pre');    
           $table->enum('rate',['bad','normal','good'])->nullable();                

           //extra       
           $table->foreign('order_id')->references('id')->on('orders');
           $table->timestamps();

        });
    }

    public function down()
    {
        Schema::table('order_deliveries',function (Blueprint $table) {
            $table->dropForeign(['order_id']);            
        });
        Schema::dropIfExists('order_deliveries');
    }    
}
