<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\User;
use App\Order;
use Illuminate\Foundation\Testing\WithFaker;



class integrationTest extends DuskTestCase
{
    use withFaker;

    public function testIntegration()
    {
        $this->browse(function (Browser $browser_requester, Browser $browser_postmaker, Browser $browser_postmaker_2, Browser $browser_postmaker_3) {
            $requester = User::where('email','requester1@requester.nl')->first();
            $postmaker = User::where('email','postmaker1@postmaker.nl')->first();
            $orderName = $this->faker->firstName.' project '.$this->faker->randomNumber;
            $deliveryName = $this->faker->name.' oplevering';

            
            $browser_requester->visit('/#/')
                    //unit test Aanmelden
                    ->click('.login-button') 
                    ->type('email', 'requester1@requester.nl')
                    ->type('password', 'requester')
                    ->click('.login-button-confirm') 
                    ->assertSee('Home') // actie gelukt
                    ->screenshot('1 - Aanmelden')

                    //unit test Nieuwe opdracht aanmaken
                    ->visit('/home#/requester/order/new')
                    ->type('name', $orderName )
                    ->type('payment', $this->faker->randomNumber)
                    ->type('description', $this->faker->randomNumber)
                    ->click('.v-select__selections')
                    ->pause(100)
                    ->click('.menuable__content__active div div:nth-child(2)') 
                    ->click('.create-project')
                    ->waitForText('Opdracht aanpassen')
                    ->click('.publish-order')    
                    ->waitForText('Weet u het zeker?')
                    ->click('.publish-order-confirm')    
                    ->waitForText('Beschikbare opdracht')
                    ->assertSee('Beschikbare opdracht')  // actie gelukt
                    ->screenshot('2 - Nieuwe opdracht aanmaken')       

                    //unit test Bekijk en controleer nieuwe opdracht
                    ->visit('/home#/requester/orders')
                    ->waitForText($orderName)
                    ->assertSee($orderName)   // actie gelukt
                    ->screenshot('3 - Bekijk en controleer nieuwe opdracht');   


            $browser_postmaker->loginAs($postmaker)
                    //unit test Bekijk Postmaker vraagt aan opdracht aanmaken
                    ->visit('/home#/order/open/'.Order::where('title',$orderName)->first()->id)                    
                    ->waitForText('Solliciteer') 
                    ->click('.apply-button')
                    ->waitForText('Een aanvraag is reeds geplaatst')
                    ->assertSee('Een aanvraag is reeds geplaatst')  // actie gelukt
                    ->screenshot('4 - Postmaker vraagt aan opdracht aanmaken');

            $browser_requester->visit('/home#/order/open/'.Order::where('title',$orderName)->first()->id)  
                    //unit test Aanvrager accepteerd de aanvraag 
                    ->waitForText($orderName)
                    ->pause(100)
                    ->click('.accept-request-button')  
                    ->waitForText('Weet u het zeker?')
                    ->click('.accept-request-confirm')  
                    ->pause(100)
                    ->waitForText('Geaccepteerd')
                    ->assertSee('Geaccepteerd') // actie gelukt
                    ->screenshot('5 - Aanvrager accepteerd de aanvraag');

           $browser_postmaker_2->pause(100)
                    //unit test De postmaker maakt de post
                    ->loginAs($postmaker)
                    ->visit('/home#/order/open/'.Order::where('title',$orderName)->first()->id)  
                    ->waitForText($orderName)
                    ->pause(100)                    
                    ->click('.temp-delivery')
                    ->waitForText('Voorbeeld oplevering')
                    ->type('temp-delivery-title', $deliveryName)                    
                    ->type('temp-delivery-description', $deliveryName.' omschrijving')
                    ->attach('temp-delivery-file', storage_path($this->faker->image('public/storage/faker',400,300, null, false)))
                    ->click('.v-input--selection-controls__ripple')
                    ->pause(100)
                    ->click('.tmp-delivery-btn')
                    ->pause(100)
                    ->click('.tmp-delivery-btn-confirm')
                    ->pause(100)
                    ->waitForText($deliveryName)
                    ->assertSee($deliveryName) //actie gelukt
                    ->screenshot('6 - De postmaker maakt de post');

            $browser_requester->visit('/home#/order/open/'.Order::where('title',$orderName)->first()->id)
                    //unit test De aanvrager keurt de tussenoplevering
                    ->waitForText('Accepteren of verbeteren van de oplevering')
                    ->click('.final-delivery-btn')                
                    ->waitForText('Goedkeuren van de tijdelijke opleveringen?')
                    ->pause(1000)             
                    ->click('.final-delivery-confirm-btn')
                    ->waitForText('Wacht op de de eindoplevering')
                    ->assertSee('Wacht op de de eindoplevering')//gelukt
                    ->screenshot('7 - De aanvrager keurt de tussenoplevering');

            $browser_postmaker_2->pause(100) 
                //unit test De postmaker doet een eindoplevering     
                    ->loginAs($postmaker)
                    ->visit('/home#/order/open/'.Order::where('title',$orderName)->first()->id)
                    ->waitForText('Er zijn geen berichten')
                    ->click(".upload-final")
                    ->waitForText('Eind oplevering')
                    ->assertSee('Eind oplevering') //gelukt
                    ->screenshot('8 - De postmaker doet een eindoplevering');

             $browser_postmaker_3->loginAs($postmaker)
             //unit test Download de oplevering
                    ->visit('/home#/order/open/'.Order::where('title',$orderName)->first()->id) 
                    ->waitForText('Er zijn geen berichten')
                    ->click('.archive-order-btn')
                    ->pause(100)
                    ->waitForText('Heeft u een betaling ontvangen?')                    
                    ->click('.archive-order-btn-confirm')
                    ->waitForText('Geen actie')
                    ->pause(1000)
                    ->assertSee($deliveryName)//gelukt
                    ->screenshot('8 - Download de oplevering');
        });
    }
}
