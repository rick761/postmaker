<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class MessageController extends Controller
{
    //
    public function new(Request $request){

        $order= App\Order::where('id',$request->input('order_id'))
            ->where(function($q) use ($request){
                $q->where('user_id', $request->user()->id)
                ->orWhere('postmaker_id', $request->user()->id);
            });                                                             

        if($order->count()){  
            
             //notification
             $theOrder = $order->first();
             $userId = ( $theOrder->postmaker_id == $request->user()->id) ? $theOrder->user_id : $theOrder->postmaker_id ; 
             $title  =  $order->first()->title;
             $uName =  $request->user()->first_name;        
             $m = "";
             $newNotification = App\Notification::create([
                 'user_id' => $userId,
                 'message' => "bericht van ".$uName." bij ".$theOrder->title.".",
                 'url' => 'order/'.$request->input('order_id')
             ]);        
             event(new App\Events\newNotification($newNotification));
            //endnotification


            $message = App\Message::create([
                'text'      =>  $request->input('text'),
                'user_id'     =>  $request->user()->id,
                'order_id'  =>  $request->input('order_id'),
            ]);
            return $message;                
        }

       

        /**Notification**/
        // $title  =  $order->first()->title;
        // $uName =  $request->user()->first_name;        
        // $m = "";        
        // if($request->state == "denied"){      $m = $uName." heeft een oplevering afgewezen voor ".$title."."; }
        // if($request->state == "in_progress"){   $m = $uName." wacht op content voor ".$title."."; }
        // if($request->state == "accepted"){       $m = $uName." Heeft de oplevering geaccepteerd voor ".$title."."; }
        // if($request->state == "stop"){        $m = $uName." Heeft aangegeven te willen stoppen met ".$title."."; }
        // if($request->state == "payed"){        $m = $uName." Heeft de een betaling gedaan voor ".$title."."; }
        // $newNotification = App\Notification::create([
        //     'user_id' => $order->first()->postmaker_id,
        //     'message' => $m,
        //     'url' => 'order/'.$request->input('id')
        // ]);        
        // event(new App\Events\newNotification($newNotification));
        /***/
        
        return ['errors' => ['new' => 'Kan geen nieuw bericht plaatsen' ] ];
    }
}
