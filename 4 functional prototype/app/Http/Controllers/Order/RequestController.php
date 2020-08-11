<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App;


class RequestController extends Controller
{
    //
    function put(Request $request){
        $order_id = $request->order_id;
        $user_id = Auth::id();

        $orderRequest = App\OrderRequest::firstOrCreate([
            'postmaker_id' => $user_id,
            'order_id' => $order_id 
        ]);

        $orderRequest->payment = $request->apply['payment'];
        if($request->apply['text'])
            $orderRequest->text = $request->apply['text'];
        $orderRequest->status = 'open';      
        $orderRequest->save();

        return $orderRequest;
    }

    function withrawn(Request $request){        
        $order_id = $request->order_id;
        $user_id = Auth::id();

        $orderRequest = App\OrderRequest::firstOrCreate([
            'postmaker_id' => $user_id,
            'order_id' => $order_id 
        ]);

        $orderRequest->status = 'withrawn';       
        $orderRequest->save();

        return $orderRequest;
    }

    function withrawAll(Request $request){
        $order_id = $request->order_id;
        $order = App\Order::find($order_id);
        $isMyOrder = $order->user_id == Auth::id();
        if($isMyOrder){
            $requests = $order->order_requests();
            return $requests->update(['status' => 'withrawn']);
        }        
    }

    function deny(Request $request){
        $request_id = $request->request_id;      
        $orderRequest = App\OrderRequest::with('order')->find($request_id);
        $order_id = $orderRequest->order->id;
        $user_id = Auth::id();
        $isOpenRequest = $orderRequest->status == 'open';
        $isMyOrder =  App\Order::where([ 'id' => $order_id, 'user_id' => $user_id ])->count() ; 

        if($isMyOrder && $isOpenRequest){
            $orderRequest->status = 'denied';
            return $orderRequest->save();
        }   
    }

    function accept(Request $request){
        $request_id = $request->request_id;      
        $orderRequest = App\OrderRequest::with('order')->find($request_id);
        $order_id = $orderRequest->order->id;
        $user_id = Auth::id();
        $isOpenRequest = $orderRequest->status == 'open';
        $isMyOrder =  App\Order::where([ 'id' => $order_id, 'user_id' => $user_id ])->count() ; 

        if($isMyOrder && $isOpenRequest){
            $orderRequest->status = 'accepted';
            return $orderRequest->save();
        }        
    }
}
