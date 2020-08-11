<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class RequestController extends Controller
{
    //
    public function put(Request $request){      
        
        if($request->user()->type == "Postmaker" ){

            $OBJrequest = App\Request::updateOrCreate([ 
                'order_id' => $request->input('order_id'),
                'postmaker_id' => $request->user()->id
            ]);

            $OBJrequest->update( [
                'text' => $request->input('text'),
                'status' => 'open'
                ]);

            return  $OBJrequest->first();
        }         

        return ['errors' => ['put' => 'Kan geen nieuwe aanvraag doen'] ];      
    
    }


    public function accept(Request $request){ 

        $req = App\Request::where('id', $request->input('id') )->with(['order.user']);
        $isOwner = $req->first()->order->user->id == $request->user()->id;
        
        if($isOwner){
            $done = $req->update(['status' => 'accepted']);
            if($done){
                $changeOrderToPostmaker = App\Order::where('id', $request->input('order_id'))->update([ 
                    'postmaker_id' => $request->input('postmaker_id'),
                    'state'=>'in_progress',
                    'postmaker_state'=>'in_progress'
                    ]
                );
                if($changeOrderToPostmaker){
                    return App\Order::where('id', $request->input('order_id'))->with(['requests.postmaker'])->first()->requests;
                }
            }
        }

        return ['errors' => ['accept' => 'Kan geen aanvraag accepteren.']];
    }


    public function decline(Request $request){   
        $req = App\Request::where('id', $request->input('id') )->with(['order.user']);    
        $isOwner = $req->first()->order->user->id == $request->user()->id;

        if($isOwner){
            $done = $req->update([ 'status' => 'denied' ] );

            if($done){
                return App\Order::where('id', $request->input('order_id'))->with(['requests.postmaker'])->first()->requests;
            }

        }        

        return ['errors' => ['accept' => 'Kan geen aanvraag afwijzen.']];
    }

    public function delete(Request $request){
        $requests = App\Order::where('id', $request->input('order_id'))->with(['requests'])->first()->requests;

        foreach($requests as $request ){
            return $request->delete();
        }

        return ['errors' => [ 'delete' => 'Kan geen aanvraag deleten.' ] ];
    }
}
