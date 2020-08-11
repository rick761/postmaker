<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {      
        DB::table('users')->insert(
            [
                'first_name' => 'Rick',
                'last_name' => 'van Megen',
                'email' => 'postmaker@postmaker.nl',
                'email_verified_at' => now(),
                'password' => Hash::make('postmaker'),
                'phone' =>'06-12345678',
                'type' => 'Postmaker',
                
            ]
        );

        DB::table('users')->insert(    [
                'first_name' => 'Arko',
                'last_name' => 'Elsenaar',
                'email' => 'contentaanvrager@contentaanvrager.nl',
                'email_verified_at' => now(),
                'password' => Hash::make('postmaker'),
                'phone' =>'06-12345678',
                'type' => 'Contentaanvrager',
                
            ]
        );

        DB::table('users')->insert(
            [
                'first_name' => 'Jan',
                'last_name' => 'Jansen',
                'email' => 'postmaker2@postmaker.nl',
                'email_verified_at' => now(),
                'password' => Hash::make('postmaker'),
                'phone' =>'06-12345678',
                'type' => 'Postmaker',
                
            ]
        );

        DB::table('users')->insert(    [
                'first_name' => 'Piet',
                'last_name' => 'Pieterse',
                'email' => 'contentaanvrager2@contentaanvrager.nl',
                'email_verified_at' => now(),
                'password' => Hash::make('postmaker'),
                'phone' =>'06-12345678',
                'type' => 'Contentaanvrager',
                
            ]
        );

        DB::table('orders')->insert([
            'title'=> 'Arkos Quest',
            'description'=> $faker->sentence,
            'user_id'=>'2',
            'postmaker_id'=>'1',
            'payment'=>$faker->randomNumber(2),
            'deliver'=>$faker->dateTimeBetween('now','+1 years')->format('Y-m-d'),
            'state'=> 'in_progress',
            'postmaker_state'=>'in_progress'
        ]);

        DB::table('orders')->insert(    [
            'title'=> 'Arkos second Quest',
            'description'=> $faker->sentence,
            'user_id'=>'2',            
            'payment'=>$faker->randomNumber(2),
            'deliver'=>$faker->dateTimeBetween('now','+1 years')->format('Y-m-d'),
            'state'=> 'open',
            'postmaker_state'=>'none'
            ]
        );        
    }
}
