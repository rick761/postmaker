<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Illuminate\Support\Facades\Auth;
use App\Events\NewNotification;

class DeliveryCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    public function create(Request $request){
        $deliveryId = $request->deliveryId;
        $msg = $request->msg;
        $delivery = App\OrderDelivery::with(['order.user','order.postmaker'])->find($deliveryId);
        $isOwner = $delivery->order->postmaker->id == Auth::id();
        $isPostmaker = $delivery->order->user->id == Auth::id();

        if($isOwner || $isPostmaker){
            $orderDeliveryComment = $delivery->order_delivery_comments()->create([
                'user_id' => Auth::id(),
                'text' => $msg
            ]) ;
            $this->launchNotification($orderDeliveryComment);
            return  $orderDeliveryComment;
        }       
    }

    public function get(Request $request, $deliveryId = null){
        $delivery = App\OrderDelivery::with('order_delivery_comments')->find($deliveryId);
        return $delivery->order_delivery_comments;   
    }

    private function launchNotification($orderDeliveryComment){   
        $isPostmaker = Auth::User()->type == 'postmaker';     
        $isRequester = Auth::User()->type == 'requester';     
        $order_delivery = $orderDeliveryComment->order_delivery()->first();
        $order = $order_delivery->order()->first();
        $msg = "Bericht ontvangen over de oplevering '".$order_delivery->title."' van opdracht '".$order->title."'";
        $user_id;

        if($isPostmaker){
            $user_id = $order->user_id;
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
