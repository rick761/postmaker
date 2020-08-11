<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    //$rand = [factory(App\User::class),]
    $rand = rand(0,3);
    return [
        
        'title'=>$faker->word,

        'user_id' => factory(App\User::class),

        'description'=>$faker->paragraph(10),

        'postmaker_id' => function($rand){
            if( $rand == 3 ){ 
                return factory(App\User::class)->create([
                    'type' => 'postmaker',
                ]);
            };            
        },

        'payment'=>$faker->randomNumber(2),

        'deliver'=>$faker->dateTimeBetween('now','+1 years')->format('Y-m-d'),

        'state'=> function($rand){

            if($rand == 3){
                return 'in_progress';
            }else {
                return 'open';
            }

        },

        'postmaker_state'=> function($rand){

            if($rand == 3){
                return 'in_progress';
            }else {
                return 'none';
            }      

        } 
    ];    
});

