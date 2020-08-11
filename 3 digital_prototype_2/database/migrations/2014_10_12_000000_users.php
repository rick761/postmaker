<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            //keys
            $table->uuid('id')->primary();

            //fields
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('type',['postmaker','requester','admin']);
            $table->string('avatar')->nullable();
            $table->string('description')->nullable();
            $table->string('likes')->nullable();;
            $table->string('display_name')->nullable();
            $table->string('company')->nullable();
            $table->string('website')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            //extra
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
