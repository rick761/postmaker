<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use App\User;
class createOrderSuccessTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    use withFaker;


    public function test_success_create_order_and_publish()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::where('email','requester1@requester.nl')->first()->id)
                    ->visit('/home#/requester/order/new')
                    ->type('name', $this->faker->firstName.' project')
                    ->type('payment', $this->faker->randomNumber)
                    ->type('description', $this->faker->randomNumber)
                    ->click('.v-select__selections')->click('.menuable__content__active div div:nth-child(2)') //aanvrager of postmaker  
                    ->click('.create-project')
                    ->waitForText('Opdracht aanpassen')
                    ->click('.publish-order')    
                    ->waitForText('Weet u het zeker?')
                    ->click('.publish-order-confirm')    
                    ->waitForText('Beschikbare opdracht')
                    ->assertSee('Beschikbare opdracht')                     
                    ->screenshot('test_success_create_order');
        });
        
    }
}
