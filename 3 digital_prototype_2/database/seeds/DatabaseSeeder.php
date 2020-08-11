<?php

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        
        $users = [
                    [  
                        'id' =>   Str::uuid(),    
                        'first_name' => Str::random(10),
                        'last_name' => Str::random(10),
                        'email' => 'rick@rick.com',
                        'password' => Hash::make('rick'),
                        'type' => 'admin',
                    ]
                ];

        DB::table('users')->insert($users);        
        
    }
}
