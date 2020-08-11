<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Orders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();           
            $table->foreignId('user_id');
            $table->foreignId('postmaker_id')->nullable();
            $table->string('title')->nullable();
            $table->longText('description')->nullable();            
            $table->foreign('user_id')->references('id')->on('users');            
            $table->foreign('postmaker_id')->references('id')->on('users');
            $table->string('payment')->nullable(); ;           
            $table->date('deliver')->nullable(); ;
            $table->enum('state', ['create','open','in_progress','declined','accepted','payed','stop','archive'])->default('create');
            $table->enum('postmaker_state', ['none','in_progress','delivered','stop','payed'])->default('none');
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
        Schema::table('orders',function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['postmaker_id']);
        });
        Schema::dropIfExists('orders');
    }
}
