<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\User;
use App\Order;
use Illuminate\Foundation\Testing\WithFaker;

class communicationTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */

    use withFaker;

    public function test_communication()
    {
        $this->browse(function (Browser $postmaker_browser, Browser $requester_browser ) {
            $requester = User::where('email','requester1@requester.nl')->first();
            $postmaker = User::where('email','postmaker1@postmaker.nl')->first();
            $order = new Order();
            
            $order->title = $this->faker->firstName.' project '.$this->faker->randomNumber;
            $order->type = "image";
            $order->payment=0;
            $order->description="123";
            $order->user_id = $requester->id;
            $order->postmaker_id = $postmaker->id;
            $order->save();
            
            $postmaker_browser
                ->LoginAs($postmaker)
                ->visit('/home#/order/open/'.$order->id)
                ->screenshot('communication_1')

            
            ;
            $requester_browser->visit('/')
                ->LoginAs($requester)                
                ->visit('/home#/order/open/'.$order->id)
                ->screenshot('communication_2')

            ;
                    
        });
    }
}
