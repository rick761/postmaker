<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App;
use Illuminate\Database\Eloquent\Builder;

class OrdersController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function get(){        
        $id = Auth::Id();
        $type = Auth::User()->type;

        if($type == 'requester'){
            return App\Order::where('user_id', $id)
            ->whereIn('state', [
                'create',
                'open',
                'progress',
                'delivered',
                'delivery_accepted',
                'final_delivered',               
            ])
            ->with('order_files')
            ->get();    
        }    
        if($type == 'postmaker'){
            return App\Order::where('postmaker_id',$id)
            ->whereIn('state', [                
                'progress',
                'delivered',
                'delivery_accepted',
                'final_delivered',                
            ])
            ->with('order_files')
            ->get();
        }

    }

    public function available(){        
        return App\Order::where('state','open')
        ->with(['user','order_files','order_tags'])
        ->get();    
    }

    public function requested(){
        $isPostmaker = Auth::user()->type == 'postmaker';
        $isRequester = Auth::user()->type == 'requester';
        $user_id = Auth::id();
        
        if($isPostmaker){

            $orders = App\Order::whereHas( 'order_requests', function(Builder $query) use ($user_id){
                return $query->where('postmaker_id', '=', $user_id );
            })
            ->with(['order_requests' => function($q) use ($user_id){
                $q->where(
                    [
                        'order_requests.postmaker_id' => $user_id
                    ]
                );
            }])             
            ->where([ 'state' => 'open']);
            return $orders->get();
        }

        if($isRequester){            
           return App\Order::whereHas( 'order_requests' )
           ->where( [ 'state' => 'open', 'user_id' => Auth::id() ] )
           ->with('order_requests.postmaker')
           ->get();
        }      

    }

    public function archived(){
        $id = Auth::Id();
        $type = Auth::User()->type;

        if($type == 'requester'){
            return App\Order::where('user_id', $id)
            ->whereIn('state', [
                'quit','removed', 'recieved_payment','quit_postmaker'
            ])
            ->get();    
        }    

        if($type == 'postmaker'){
            return App\Order::where('postmaker_id',$id)
            ->whereIn('state', [                
                'quit', 'recieved_payment','quit_postmaker'
            ])
            ->get();
        }

    }

    public function archivedSuccess(){
        $id = Auth::Id();
        $type = (Auth::User()->type == 'postmaker') ? 'postmaker_id' : 'user_id';

        
        $orders = App\Order::where($type, $id)
        ->whereIn('state', [
            'recieved_payment'
        ])
        ->get();           
       

        foreach($orders as $order){

            $order->archivedSuccess = []; 

            $order_deliveries = $order->order_deliveries()->get(); 
            for($i=0; $i<count($order_deliveries);$i++){
                $results =  $order_deliveries[$i]->order_delivery_files()
                    ->where('is_invoice','0')    
                    ->where('url','like', '%.jpg')                   
                    ->orWhere('url','like', '%.png')                  
                    ->get();

                $order->archivedSuccess = array_merge($order->archivedSuccess,$results->toArray());
            }
            
        }

        return $orders;
        
    }


}
