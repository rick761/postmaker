<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserShowDeliveries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_show_deliveries', function (Blueprint $table) {
            $table->id();            
            $table->uuid('user_id');
            $table->foreignId('order_delivery_file_id');            
            
            //extra
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('order_delivery_file_id')->references('id')->on('order_delivery_files');
            
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
        Schema::dropIfExists('user_show_deliveries');
    }
}
