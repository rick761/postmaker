<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Order;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;

class applyForOrderTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    use withFaker;

    public function test_success_apply_and_accept_for_order()
    {      
        $this->browse(function (Browser $create_order_browser, Browser $apply_order, Browser $accept_order ) {
            $requester = User::where('email','requester1@requester.nl')->first();
            $postmaker = User::where('email','postmaker1@postmaker.nl')->first();
            $orderName = $this->faker->firstName.' project '.$this->faker->randomNumber;

            $create_order_browser->loginAs($requester)
                    ->visit('/home#/requester/order/new')
                    ->type('name',$orderName)
                    ->type('payment', $this->faker->randomNumber)
                    ->type('description', $this->faker->email)
                    ->click('.v-select__selections')->click('.menuable__content__active div div:nth-child(2)') //aanvrager of postmaker  
                    ->click('.create-project')
                    ->waitForText('Opdracht aanpassen')
                    ->click('.publish-order')    
                    ->waitForText('Weet u het zeker?')
                    ->click('.publish-order-confirm')    
                    ->waitForText('Beschikbare opdracht')
                    ->assertSee('Beschikbare opdracht')   
                    ->screenshot('test_success_apply_order_1');  


            $apply_order->loginAs($postmaker)
                    ->visit('/home#/order/open/'.Order::where('title',$orderName)->first()->id)
                    ->pause(300)                   
                    ->waitForText('Solliciteer')                    
                    ->click('.apply-button')
                    ->waitForText('aanvraag')                    
                    ->assertSee('aanvraag')
                    ->screenshot('test_success_apply_order_2');  

            $accept_order->loginAs($requester)
                    ->visit('/home#/order/open/'.Order::where('title',$orderName)->first()->id)
                    ->pause(1000)
                    // ->waitForText('Accepteren')
                    ->click('.accept-request-button')
                    ->waitForText('Weet u het zeker?')
                    ->click('.publish-order-confirm')    
                    ->pause(300)
                    ->waitForText('Chatbox')
                    ->assertSee('Chatbox')
                    ->screenshot('test_success_apply_order_3');  

            

        });

        // $this->browse(function (Browser $browser) {
        //     $order = Order::where('state', 'open')->first();            
        //     $order_id = $order->id;            
        //     $user_id = User::where('email','postmaker1@postmaker.nl')->first()->id;
        //     $browser->loginAs($user_id)
        //             ->visit('/home#/order/open/'.$order_id)

        //             ->click('.apply-button')
        //             //->click('.re-apply-button')
        //             ->waitForText('Een aanvraag is reeds geplaatst')
        //             ->assertSee('Een aanvraag is reeds geplaatst')
        //             ->screenshot('test_succes_apply_for_order');                    
        // });
    }
}
