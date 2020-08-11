<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Illuminate\Support\Facades\Auth;


class TagController extends Controller
{
    //
    public function save(Request $request){
        $user_id = Auth::id();
        $order_id = $request->order_id;
        $tags = $request->tags;
        $order = App\Order::where([ 'user_id'=>$user_id, 'id'=> $order_id ]);
        $isMyOrder = $order->count();

        if($isMyOrder){
            $order->first()->order_tags()->delete();
            foreach($tags as $tag){        
                App\OrderTag::create([              
                    'text'=> $tag['text'],
                    'order_id' =>  $order_id
                ]);               
            }    
        }  
    }
}
