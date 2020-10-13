<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\WithFaker;

class loginFailTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    use withFaker;

    public function test_fail_login()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/#/')
                ->click('.login-button') 
                ->type('email', 'a@b.nl')
                ->type('password', '!@#$%%^^&*&(')
                ->click('.login-button-confirm') 
                ->waitForText('These credentials do not match our records.')
                ->assertSee('These credentials do not match our records.')
                ->screenshot('test_fail_login');
        });
    }
}
