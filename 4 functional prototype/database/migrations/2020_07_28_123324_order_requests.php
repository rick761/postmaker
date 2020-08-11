<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrderRequests extends Migration
{
    public function up()
    {
        Schema::create('order_requests', function (Blueprint $table) {
            //keys
            $table->id();         
            $table->uuid('postmaker_id');
            $table->uuid('order_id');      

            //fields
            $table->string('text')->nullable();
            $table->integer('payment')->nullable();
            $table->enum('status', [ 'open', 'denied', 'accepted', 'withrawn' ])->default('open');   

            //extra
            $table->foreign('postmaker_id')->references('id')->on('users');    
            $table->foreign('order_id')->references('id')->on('orders');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('order_requests',function (Blueprint $table) {
            $table->dropForeign(['order_id']);         
            $table->dropForeign(['postmaker_id']);     
        });
        Schema::dropIfExists('order_requests');
    }    
}
