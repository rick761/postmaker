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
        $me = Auth::User();

        return $me->orders()->get();        
    }

    public function available(){        
        return App\order::where('state','open')
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
                $q->where('order_requests.postmaker_id', '=', $user_id);
            }]);  

            return $orders->get();
        }

        if($isRequester){            
           return App\Order::whereHas( 'order_requests' )
           ->where( [ 'state' => 'open', 'user_id' => Auth::id() ] )
           ->with('order_requests.postmaker')
           ->get();
        }       

    }


}
