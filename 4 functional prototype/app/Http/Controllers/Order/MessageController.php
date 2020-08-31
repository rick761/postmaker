<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Illuminate\Support\Facades\Auth;
use App\Events\NewNotification;

class MessageController extends Controller
{
    //
    public function send(Request $request){
        $order_id = $request->order_id;
        $text = $request->text;
        $url = $request->url;
        $order = App\Order::find($order_id);
        $auth_id = Auth::id();
        $isMyOrder = ($order->user_id == $auth_id || $order->postmaker_id == $auth_id);

        if($isMyOrder){
            $message = $order->order_messages()->create([
                'text'=>$text,
                'url'=>$url,
                'user_id' => $auth_id 
            ]);             
            $this->launchNotification($message);
            return $message;   
        }                
    }

    private function launchNotification($message){   
        $order = $message->order()->first();
        $isPostmaker = Auth::User()->id == $order->postmaker_id;     
        $isRequester = Auth::User()->id == $order->user_id;   
        $user_id = $order->user_id;  
        $msg = 'Bericht: '. $message->text;

        if($message->url){
            $msg .= '{{'.$message->url.'}}';
        }

        if($isRequester){
            $user_id = $order->postmaker_id;
        }
        
        $newNotification = App\Notification::create([
            'user_id'   =>      $user_id,
            'text'      =>      $msg,
            'url'       =>      '/order/open/'.$order->id
        ]);

        event(new NewNotification($newNotification));

    }
}
