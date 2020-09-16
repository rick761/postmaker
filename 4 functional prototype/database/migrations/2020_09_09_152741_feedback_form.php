<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FeedbackForm extends Migration
{
    public function up()
    {
        Schema::create('feedback_forms', function (Blueprint $table) {

            $table->id();            
            $table->integer('version')->default(0);
            $table->string('story');    
            $table->integer('rate');  
            $table->longText('feedback')->nullable();  
            $table->longText('notation')->nullable();    
            
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
        Schema::dropIfExists('feedback_forms');
    }

}
