<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\NewNotification;
use App;

class OrderController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request){       
        $me = Auth::User();        

        $order = new App\Order;        
        $order->description = $request->description;
        $order->payment = $request->payment;
        $order->state = 'create';
        $order->title = $request->title;
        $order->type = $request->type;
        $order->deliver = $request->deliver;
        
        return  $me->orders()->save($order);
    }

    public function get(Request $request, $orderId = null){ 

        if(!$orderId) return;               
        $isOwner = App\Order::where( [ 'user_id' => auth::id(), 'id'=> $orderId ] )->count();      
        $isPostmaker = (Auth::User()->type == 'postmaker');

        if($isOwner){
            return App\Order::with([
                'user',
                'order_files',
                'postmaker',
                'order_descriptions',
                'order_requests.postmaker',
                'order_deliveries.order_delivery_files',
                'order_deliveries.order_delivery_comments',
                'order_tags',
                'order_messages'
            ])->find($orderId);
        }

        if(!$isOwner){    
            if($isPostmaker){
                return App\Order::with( [
                    'user',
                    'postmaker',
                    'order_files',
                    'order_tags',
                    'order_descriptions',
                    'order_deliveries.order_delivery_files',
                    'order_deliveries.order_delivery_comments',
                    'order_messages',
                    'order_requests' => function($q){
                        $q->where('order_requests.postmaker_id', '=', Auth::id());
                    }
                ] )->find($orderId);
            }
            return App\Order::with(['user','postmaker'])->find($orderId);
        }       
              
    }

    public function update(Request $request){    
        
        $order = App\Order::with(['user','postmaker'])->find($request->id);         
        
        $isOwner = $order->user->id == Auth::id();
        $isPostmaker = 0; 

        if(isset($order->postmaker)){
            $isPostmaker =  $order->postmaker->id == Auth::id();
        }

        $update = [];

        if($isOwner){
            if($request->title){
                $update['title'] = $request->title;
            }
            if($request->deliver){
                $update['deliver'] = $request->deliver;
            }
            if($request->description){
                $update['description'] = $request->description;
            }
            if($request->payment){
                $update['payment'] = $request->payment;
            }
            if($request->type){
                $update['type'] = $request->type;
            }
        }
        if($isOwner || $isPostmaker){
            if($request->state){
                $currentState = $order->state; 
                $newState = $request->state;   

                if($isPostmaker){
                    if( 
                        ($newState == 'delivered'           &&  ($currentState == 'progress' || $currentState == 'delivered' )) ||                        
                        ($newState == 'progress'            &&  $currentState == 'quit_postmaker' )  ||                        
                        ($newState == 'quit_postmaker'      &&  ($currentState == 'progress' || $currentState == 'delivered' )) ||                        
                        ($newState == 'final_delivered'     &&  ($currentState == 'delivery_accepted'|| $currentState == 'final_delivered' )) || 
                        ($newState == 'recieved_payment'    &&  ($currentState == 'final_delivered' || $currentState == 'delivery_accepted' ))                       

                    ){
                        $update['state'] = $request->state;
                        $this->launchNotification($order, $request->state, $currentState);
                    }           
                }
                if($isOwner){
                    if( 
                        ($newState == 'progress'            &&  $currentState == 'open' ) ||
                        ($newState == 'create'              &&  $currentState == 'open' ) ||
                        ($newState == 'removed'              &&  ($currentState == 'open' || $currentState == 'create' )) ||
                        ($newState == 'quit'                &&  ($currentState == 'progress' || $currentState == 'delivered' )) ||                        
                        ($newState == 'delivery_accepted'     &&  ($currentState == 'progress' || $currentState == 'delivered' )) ||                        
                        ($newState == 'progress'            &&  $currentState == 'delivered' ) ||
                        ($newState == 'open'            &&  $currentState == 'create' ) 
                    ){
                        $update['state'] = $request->state;
                        $this->launchNotification($order, $request->state, $currentState);
                    }                                        
                }                
            } 
        }             

        return $order->update( $update );
    }

    private function launchNotification($order, $newState, $prevState){       

        $msg = 'Er is iets fout gegaan.';
        $for = $order->user_id;        
        $url = '/order/open/'.$order->id;
        $send = false;
        $postmakerId = 0;

        if(isset($order->postmaker)){
            $postmakerId = $order->postmaker->id; 
        }

        //voor de postmaker
        if($newState == 'quit'){
            $msg = 'Eigenaar van een opdracht heeft besloten te stoppen.';
            $send = true;
            $for = $postmakerId;
        }

        if($newState == 'progress' && $prevState=="delivered"){
            $msg = 'Er is een verbetering gewenst op een oplevering.';
            $send = true;   
            $for = $postmakerId;        
        }    

        if($newState == 'delivery_accepted' && $prevState == "progress"){
            $msg = 'Je kan een eindoplevering doen bij een opdracht, zonder dat er een tussenoplevering is gedaan.';
            $send = true;   
            $for = $postmakerId;        
        }   

        if($newState == 'delivery_accepted' && $prevState == "delivered"){
            $msg = 'De opleveringen zijn goedgekeurd, je kan de eindoplevering doen.';
            $send = true;   
            $for = $postmakerId;        
        }   

        //voor de eigenaar
        if($newState == 'final_delivered'){
            $msg = 'Een eindoplevering is gedaan.';
            $send = true;            
        }

        if($newState == 'recieved_payment' && $prevState=="final_delivered" ){
            $msg = 'Een bedrag is ontvangen, project is succesvol afgerond.';
            $send = true;            
        }

        if($newState == 'recieved_payment' && $prevState=="final_delivered" ){
            $msg = 'Een bedrag te hebben ontvangen zonder een eindoplevering, project is succesvol afgerond.';
            $send = true;            
        }

        if($newState == 'quit_postmaker'){
            $msg = 'Een postmaker geeft aan te stoppen, neem contact op.';
            $send = true;            
        }

        if($prevState == 'quit_postmaker' && $newState == 'progress'){
            $send = true;  
            $msg = 'Een postmaker geeft aan toch te willen doorgaan, neem contact op.';
        }

        if($newState == 'delivered'){
            $msg = 'Een oplevering is gedaan.';
            $send = true;           
        }      
       
        if($send){
            $newNotification = App\Notification::create([
                'user_id'   =>      $for,
                'text'      =>      $msg,
                'url'       =>      $url
            ]);
            event(new NewNotification($newNotification));
        }        
    }

    public function connectPostmaker(Request $request, $orderId){ // to order

        $order = App\Order::where([
           'id' => $orderId,
           'user_id' => Auth::id()
        ])->with('order_requests.postmaker')->first();

        $requests = $order->order_requests;    
        foreach($requests as $request){
            if($request->status == 'accepted'){
                $order->postmaker_id = $request->postmaker_id;
                return $order->save();
            }
        }        
    }

    public function like(Request $request, $orderId = null){
        $order = App\Order::find($orderId);
        $isPostmaker = $order->postmaker_id == Auth::id();
        $isRequester = $order->user_id == Auth::id();
        $hasPostmaker = $order->postmaker_id != null;

        if($hasPostmaker){
            if($isRequester){
                App\User::find( $order->postmaker_id )->user_likes()->firstOrCreate([
                    'liker_id' => Auth::id(),
                    'order_id' => $order->id
                ]);
            }
            if($isPostmaker){
                App\User::find( $order->user_id )->user_likes()->firstOrCreate([
                    'liker_id' => Auth::id(),
                    'order_id' => $order->id
                ]);
            }
        }

        return 0;
    }
        
}
