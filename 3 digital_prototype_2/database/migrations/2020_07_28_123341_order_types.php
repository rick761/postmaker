<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrderTypes extends Migration
{
    public function up()
    {
        Schema::create('order_types', function (Blueprint $table) {
          
            //key
            $table->id();           

            //fields
            $table->string('icon')->nullable();
            $table->string('text')->nullable();     

            //extra                  
            $table->timestamps();
        });
    }

    public function down()
    {       
        Schema::dropIfExists('order_types');
    }    
}
