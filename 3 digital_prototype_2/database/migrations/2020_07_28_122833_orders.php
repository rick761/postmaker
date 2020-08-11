<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Orders extends Migration
{

    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            //keys
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->uuid('postmaker_id')->nullable();

            //fields
            $table->string('title')->default('Nieuw project');
            $table->longText('description');
            $table->string('payment')->nullable();
            $table->date('deliver')->nullable();
            $table->enum('state',
                ['create','open','progress','delivered','delivery_accepted','recieved_payment','quit_postmaker','quit','removed']
            )->default('create');

            //extra
            $table->foreign('user_id')->references('id')->on('users');            
            $table->foreign('postmaker_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('orders',function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['postmaker_id']);
        });
        Schema::dropIfExists('orders');
    }    
    
}
