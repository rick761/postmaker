<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App;
use App\Events\NewNotification;

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

        if($request->apply['text']){
            $orderRequest->text = $request->apply['text'];
        }

        $id = $orderRequest->id;
        $pre = $orderRequest->status;
        $orderRequest->status = 'open';
        $orderRequest->save();
        $orderRequest = App\OrderRequest::find($id);

        if($pre != 'open'){   
            $this->launchNotification($orderRequest);
        }             
        
        return $orderRequest;
    }

    function withrawn(Request $request){ 
             
        $order_id = $request->order_id;
        $user_id = Auth::id();        

        $orderRequest = App\OrderRequest::firstOrCreate([
            'postmaker_id' => $user_id,
            'order_id' => $order_id 
        ]);
        
        if($orderRequest->status != 'withrawn'){
            $orderRequest->status = 'withrawn';       
            $orderRequest->save();
            $this->launchNotification($orderRequest);
        }
        return $orderRequest;
    }

    function withrawAll(Request $request){
        $order_id = $request->order_id;
        $order = App\Order::find($order_id);
        $isMyOrder = $order->user_id == Auth::id();
        
        if($isMyOrder){
            $requests = $order->order_requests();
            foreach($requests as $request){
                $this->launchNotification($request);
            }            
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
            $this->launchNotification($orderRequest);
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
            $this->launchNotification($orderRequest);
            return $orderRequest->save();
        }        

        

    }

    private function launchNotification($orderRequest){        
        $ownerId = $orderRequest->order->user_id;        
        $postmakerId = $orderRequest->postmaker_id;
        $notificationForPostmaker = $ownerId == Auth::id();
        $notificationForRequester = $postmakerId == Auth::id();
        $msg = 'Er gaat iets fout';

        if($notificationForPostmaker){             
            if($orderRequest->status=='accepted'){ $msg = 'Aanvraag op '.$orderRequest->order->title.' is geaccepteerd'; }
            if($orderRequest->status=='denied'){ $msg = 'Aanvraag op '.$orderRequest->order->title.' is geweigerd'; }
            if($orderRequest->status=='withrawn'){ $msg = 'Aanvraag op '.$orderRequest->order->title.' is ingetrokken'; }
            
            $newNotification = App\Notification::create([
                'user_id'   =>      $postmakerId,
                'text'      =>      $msg,
                'url'       =>      '/order/open/'.$orderRequest->order->id
            ]);

            event(new NewNotification($newNotification));
        }

        if($notificationForRequester){             
            if($orderRequest->status=='open'){ $msg = 'Nieuwe aanvraag op '.$orderRequest->order->title.'.'; }
            if($orderRequest->status=='withrawn'){ $msg = 'Aanvraag op '.$orderRequest->order->title.' is ingetrokken'; }
            
            $newNotification = App\Notification::create([
                'user_id'   =>      $ownerId,
                'text'      =>      $msg ,
                'url'       =>      '/order/open/'.$orderRequest->order->id
            ]);
            event(new NewNotification($newNotification));
        }
    }
}
