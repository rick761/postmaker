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
                        'first_name' => 'requester',
                        'last_name' => 'requester',
                        'display_name' => 'requester user',                        
                        'email' => 'requester@requester.nl',
                        'password' => Hash::make('requester'),
                        'type' => 'requester',
                    ],
                    [          
                        'id' => Str::uuid(),                   
                        'first_name' => 'postmaker',
                        'last_name' => 'postmaker',
                        'display_name' => 'postmaker user',                        
                        'email' => 'postmaker@postmaker.nl',
                        'password' => Hash::make('postmaker'),
                        'type' => 'postmaker',
                    ],

                ];

        DB::table('users')->insert($users);     
        
        factory(App\Order::class, 20)->create();
        
    }
}
