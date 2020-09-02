<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

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
                        'id' => Str::uuid(),                     
                        'first_name' => 'admin',
                        'last_name' => 'admin',
                        'display_name' => 'Super user',                        
                        'email' => 'admin@admin.nl',
                        'password' => Hash::make('admin'),
                        'type' => 'admin',
                    ],

                    [          
                        'id' => Str::uuid(),                     
                        'first_name' => 'Jan',
                        'last_name' => 'Jansen',
                        'display_name' => 'Jan Jansen',                        
                        'email' => 'requester1@requester.nl',
                        'password' => Hash::make('requester'),
                        'type' => 'requester',
                    ],

                    [          
                        'id' => Str::uuid(),                     
                        'first_name' => 'Willem',
                        'last_name' => 'van de Berg',
                        'display_name' => 'Willem van de Berg',                        
                        'email' => 'requester2@requester.nl',
                        'password' => Hash::make('requester'),
                        'type' => 'requester',
                    ],

                    [          
                        'id' => Str::uuid(),                     
                        'first_name' => 'Pieter',
                        'last_name' => 'Post',
                        'display_name' => 'Pieter Post',                        
                        'email' => 'requester3@requester.nl',
                        'password' => Hash::make('requester'),
                        'type' => 'requester',
                    ],

                    [          
                        'id' => Str::uuid(),                     
                        'first_name' => 'Freek',
                        'last_name' => 'de Bruin',
                        'display_name' => 'Freek de Bruin',                        
                        'email' => 'requester4@requester.nl',
                        'password' => Hash::make('requester'),
                        'type' => 'requester',
                    ],





                    [          
                        'id' => Str::uuid(),                   
                        'first_name' => 'Piet',
                        'last_name' => 'Pieterse',
                        'display_name' => 'Piet Pieterse',                        
                        'email' => 'postmaker1@postmaker.nl',
                        'password' => Hash::make('postmaker'),
                        'type' => 'postmaker',
                    ],

                    [          
                        'id' => Str::uuid(),                   
                        'first_name' => 'Henk',
                        'last_name' => 'de Jong',
                        'display_name' => 'Henk de Jong',                        
                        'email' => 'postmaker2@postmaker.nl',
                        'password' => Hash::make('postmaker'),
                        'type' => 'postmaker',
                    ],

                    [          
                        'id' => Str::uuid(),                   
                        'first_name' => 'Will',
                        'last_name' => 'Smit',
                        'display_name' => 'Will Smit',                        
                        'email' => 'postmaker3@postmaker.nl',
                        'password' => Hash::make('postmaker'),
                        'type' => 'postmaker',
                    ],

                    [          
                        'id' => Str::uuid(),                   
                        'first_name' => 'Kees',
                        'last_name' => 'de Kok',
                        'display_name' => 'Henk de Jong',                        
                        'email' => 'postmaker4@postmaker.nl',
                        'password' => Hash::make('postmaker'),
                        'type' => 'postmaker',
                    ],

                ];

        DB::table('users')->insert($users);     
        
        //factory(App\Order::class, 20)->create();
        
    }
}
