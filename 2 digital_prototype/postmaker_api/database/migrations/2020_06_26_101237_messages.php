<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Messages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();       

            $table->foreignId('file_id')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('order_id');

            $table->string('text');           

            $table->foreign('user_id')->references('id')->on('users');            
            $table->foreign('file_id')->references('id')->on('files');            
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
        Schema::table('messages',function (Blueprint $table) {
            $table->dropForeign(['order_id']);  
            $table->dropForeign(['file_id']);  
            $table->dropForeign(['user_id']);             
        });
        Schema::dropIfExists('messages');
    }
}
