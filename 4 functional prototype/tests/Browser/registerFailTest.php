<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\WithFaker;
class registerFailTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    use withFaker;
    public function test_fail_register()
    {               
        $this->browse(function (Browser $browser) {  
            $browser->visit('/#/')
                    ->click('.register-button')                     
                    ->type('first_name', $this->faker->asciify('************************************************************'))   
                    ->type('last_name', $this->faker->asciify('************************************************************'))  
                    ->type('display_name', $this->faker->asciify('************************************************************'))
                    ->type('email', $this->faker->asciify('************************************************************'))
                    ->type('password', 'password123')
                    ->type('password_confirmation', 'password321')                    
                    ->click('.v-select__selections')
                    ->pause(100)
                    ->click('.menuable__content__active div div:first-child') //aanvrager of postmaker  
                    ->pause(100)                    
                    ->click('.register-button-confirm') 
                    ->pause(100)
                    ->assertSee('Registreren')
                    ->screenshot('test_fail_register');
        });
    }
}
