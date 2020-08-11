<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Requests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();         
            $table->foreignId('postmaker_id');
            $table->foreignId('order_id');       

            $table->string('text')->nullable();
            $table->enum('status', [ 'open', 'denied', 'accepted' ])->default('open');            
            $table->foreign('postmaker_id')->references('id')->on('users');    
            $table->foreign('order_id')->references('id')->on('orders');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requests',function (Blueprint $table) {
            $table->dropForeign(['order_id']);  
            $table->dropForeign(['postmaker_id']);                       
        });
        Schema::dropIfExists('requests');
    }
}
