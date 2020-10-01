<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;

class createOrderFailTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    use withFaker;

    public function test_fail_create_order()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::where('email','requester1@requester.nl')->first()->id)
                    ->visit('/home#/requester/order/new')
                    ->type('name', $this->faker->firstName.' project')
                    ->click('.create-project')
                    ->assertSee('Opdracht maken')                    
                    ->screenshot('test_fail_create_order');
        });
    }

}
