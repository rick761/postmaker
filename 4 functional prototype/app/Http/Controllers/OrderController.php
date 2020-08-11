<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
                'order_tags'
            ])->find($orderId);
        }

        if(!$isOwner){    
            if($isPostmaker){
                return App\Order::with( [
                    'user',
                    'postmaker',
                    'order_requests' => function($q){
                        $q->where('order_requests.postmaker_id', '=', Auth::id());
                    }
                ] )->find($orderId);
            }
            return App\Order::with(['user','postmaker'])->find($orderId);
        }       
              
    }

    public function update(Request $request){
        $order = App\Order::find($request->id);  
        
        $update = [
            'title' => $request->title,
            'deliver' => $request->deliver,
            'description' => $request->description,
            'payment' => $request->payment,
            'type' => $request->type,
            'state' => $request->state
        ];

        return $order->update( $update );
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
}
