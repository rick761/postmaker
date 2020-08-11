<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App;

class CommentController extends Controller
{
    public function new(Request $request){  
        $order = App\Order::where('id',$request->input('order_id'))
                ->where('user_id' , Auth::id());                

        if($order->count()){
            return $order->first()->comments()->create(); 
        }

        return ['errors' => ['new' => 'Kan geen nieuwe comment aanmaken'] ];
    
    }
    public function delete(Request $request){
        $comment =  App\Comment::where('id', $request->input('id'))
                        ->with(['order.user']);
        $isMine = ( $comment->first()->order->user->id == Auth::id() );
        
        if($isMine){
            return $comment->delete();
        }
        
        return ['errors' => ['delete' => 'Kan geen comment deleten'] ];
    }

    public function update(Request $request){           
        $comment =  App\Comment::where('id', $request->input('id'))
                        ->with(['order.user']);
        $isMine = ( $comment->first()->order->user->id == Auth::id() );

        if($isMine){
            return $comment->update([ $request->input('field') => $request->input('value') ]);           
        }
        return ['errors' => ['update' => 'Kan geen comment updaten'] ];
    }
}
