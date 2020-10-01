<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App;

class DescriptionController extends Controller
{
    //
    public function save(Request $request){
        $descriptions = $request->descriptions;       
        $orderId = $request->orderId;
        $currentOrder = Auth::user()->orders()->find($orderId);

        if($currentOrder){                       
            $this->delete($currentOrder);
        }  
             
        foreach($descriptions as $description){              
            if(!isset($description['title'])){$description['title'] = '';}
            if(!isset($description['text'])){$description['text'] = '';}
            
            App\OrderDescription::create([
                    'title'=> $description['title'],
                    'text'=> $description['text'],
                    'order_id' => $currentOrder->id
            ]);
        }        

    }

    private function delete($order){
        $order->order_descriptions()->delete();
    }
}
