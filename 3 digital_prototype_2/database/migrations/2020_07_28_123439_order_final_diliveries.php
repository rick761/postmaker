<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrderFinalDiliveries extends Migration
{
    public function up()
    {
        Schema::create('order_final_deliveries', function (Blueprint $table) {
           //key
           $table->id();            
           $table->uuid('order_id');  

           //fields
           $table->string('files_url')->nullable();            
           $table->string('invoice_url')->nullable();            

           //extra       
           $table->foreign('order_id')->references('id')->on('orders');
           $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('order_final_deliveries',function (Blueprint $table) {
            $table->dropForeign(['order_id']);            
        });
        Schema::dropIfExists('order_final_deliveries');
    }    
}
