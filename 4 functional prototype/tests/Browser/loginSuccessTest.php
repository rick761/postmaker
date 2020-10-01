<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\WithFaker;

class loginSuccessTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    use withFaker;
    public function test_succes_login()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/#/')
                ->click('.login-button') 
                ->type('email', 'requester1@requester.nl')
                ->type('password', 'requester')
                ->click('.login-button-confirm') 
                ->assertSee('Home')
                ->screenshot('test_success_login');
        });
    }
}
