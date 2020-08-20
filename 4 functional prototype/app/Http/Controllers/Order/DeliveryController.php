<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App;

class DeliveryController extends Controller
{
    //
    public function create(Request $request){
        $delivery = $request->delivery;
        $order_delivery_files = $request->order_delivery_files;
        $order_id = $request->order_id;
        $order = App\Order::find($order_id);
        $isPostmaker = $order->postmaker_id == Auth::id();       
        
        if($isPostmaker){
            $delivery = [
                'title' => $delivery['title'],
                'text' => $delivery['text'],
                'order_id' => $order_id 
            ];
            $delivery = App\OrderDelivery::create($delivery);

            $order = App\Order::find($order_id);
            $order->state = 'delivered';
            $order->save();

            $createArray =[];
            foreach($order_delivery_files as $order_delivery_file){
               array_push($createArray,[ 'url'  => $order_delivery_file]);
            }    
            
            $order_delivery_files = $delivery->order_delivery_files()->createMany($createArray);

            $delivery_id = $delivery->id;

            return App\OrderDelivery::with('order_delivery_files')->find($delivery_id);           
        }        
    }

    public function final_create(Request $request){
        
        $delivery = $request->delivery;
        $order_delivery_files = $request->order_delivery_files;
        $order_id = $request->order_id;
        $order = App\Order::find($order_id);
        $isPostmaker = $order->postmaker_id == Auth::id();  

        if($isPostmaker){
            $delivery = [
                'title' => 'Eindoplevering',
                'text' => '',
                'order_id' => $order_id,
                'type' => 'final' 
            ];
            $delivery = App\OrderDelivery::create($delivery);

            $order = App\Order::find($order_id);
            $order->state = 'final_delivered';
            $order->save();

            $createArray =[];              
            array_push($createArray,[
                 'url'  => $request->invoice,
                 'is_invoice' => 1 
            ]);
            foreach($order_delivery_files as $order_delivery_file){
                array_push($createArray,[ 'url'  => $order_delivery_file]);
            }  
            
            $order_delivery_files = $delivery->order_delivery_files()->createMany($createArray);

            $delivery_id = $delivery->id;

            return App\OrderDelivery::with('order_delivery_files')->find($delivery_id);   
        }

    }
    public function rate(Request $request){
        $order_delivery_id = $request->order_delivery_id;
        $rate = $request->rate;        
        $delivery = App\OrderDelivery::with('order')->find($order_delivery_id);
        $orderIsMine = $delivery->order->user_id == Auth::id();
        
        if( $orderIsMine){
            $delivery->update(['rate' => $rate  ]);
            return $rate;
        }
        
    }
}
