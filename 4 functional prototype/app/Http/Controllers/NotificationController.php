<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App;

class NotificationController extends Controller
{
    //
    public function get(Request $request){
        $notifications = App\Notification::where([
                'user_id'=>$request->user()->id,
                'removed' => 0            
            ])
            ->orderBy('read','asc')
            ->orderBy('id', 'desc')
            ->limit(50)
            ->get();
            
        return $notifications;
    }

    public function read(Request $request){
        return App\Notification::where([
            'user_id' => Auth::id(),
            'id'=>$request->id]
        )->update(['read'=>1]);  
    }

    public function remove(Request $request){
      
        return App\Notification::where([
            'user_id' => Auth::id(),
            'id'=> $request->id]
        )->update(['removed' => 1]);  
    }
}
