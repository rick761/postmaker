<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use Illuminate\Foundation\Testing\WithFaker;

class registerTest extends DuskTestCase
{
    //register-button-confirm
    /**
     * A Dusk test example.
     *
     * @return void
     */    

    use withFaker;

   

    public function test_success_register()
    {               
        $this->browse(function (Browser $browser) {
            $browser->visit('/#/')
                    ->click('.register-button')  
                    
                    ->type('first_name', $this->faker->firstName)   
                    ->type('last_name', $this->faker->lastName)  
                    ->type('display_name', $this->faker->firstName.$this->faker->lastName)
                    ->type('email', $this->faker->email)
                    ->type('password', 'password123')
                    ->type('password_confirmation', 'password123')                    
                    ->click('.v-select__selections')->click('.menuable__content__active div div:nth-child(2)') //aanvrager of postmaker  
                     ->click('.register-button-confirm') 
                    ->waitForText('Home')
                    ->assertSee('Home')
                    ->screenshot('test_success_register');;
        });
    }

    // public function test_error_register()
    // {               
    //     $this->browse(function (Browser $browser) {  
    //         $browser->visit('/#/')
    //                 ->click('.register-button')                     
    //                 ->type('first_name', $this->faker->asciify('************************************************************'))   
    //                 ->type('last_name', $this->faker->asciify('************************************************************'))  
    //                 ->type('display_name', $this->faker->asciify('************************************************************'))
    //                 ->type('email', $this->faker->asciify('************************************************************'))
    //                 ->type('password', 'password123')
    //                 ->type('password_confirmation', 'password321')
    //                 //->fillHidden('type', 'postmaker')
    //                 ->click('.v-select__selections')->click('.menuable__content__active div div:nth-child(2)') //aanvrager of postmaker  
    //                 //->screenshot('testscreenshot')
    //                 ->click('.register-button-confirm') 
    //                 ->pause(100)
    //                 ->assertSee('Registreren');
    //     });
    // }

}
