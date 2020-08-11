<?php

namespace App\Http\Controllers;
use App;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    //
    public function get(Request $request){
        $notifications = App\Notification::where('user_id',$request->user()->id)
            ->orderBy('read','asc')
            ->orderBy('id', 'desc')
            ->limit(50)
            ->get();
        return $notifications;
    }

    public function read(Request $request){
        return App\Notification::where(['user_id' => $request->user()->id, 'id'=>$request->id])
                        ->update(['read'=>1]);  
    }
}
