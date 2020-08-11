<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Notifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();  
            $table->foreignId('user_id');

            $table->string('message');
            $table->string('url')->nullable(); 
            $table->boolean('read')->default(0);      
                    
            $table->foreign('user_id')->references('id')->on('notifications');     
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
        Schema::table('notifications',function (Blueprint $table) {
            $table->dropForeign(['user_id']);                                   
        });
        Schema::dropIfExists('notifications');
    }
}
