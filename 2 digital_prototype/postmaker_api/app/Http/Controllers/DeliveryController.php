<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class DeliveryController extends Controller
{
    //
    public function upload(Request $request){
        $order_id = $request->order_id;
        $newFiles = [];

        $isMyOrderAsPostmaker = App\Order::where('id', $order_id)->where('postmaker_id',$request->user()->id)->count();
        if (!$isMyOrderAsPostmaker) {
            return ['errors' => ['upload' => 'Geen rechten voor het uploaden van een afbeelding.']];
        };

        if ($request->hasFile('files')){           
            foreach($request->file('files') as $file){ 

                $name = $file->getClientOriginalName();
                $ext= strtolower($file->getClientOriginalExtension());

                $path = $file->storeAs(
                    'deliverys/'.$request->user()->id, // directory of user id
                    $name, 
                    'public' // public folder
                );   

                $file = App\File::create( ['url' => $path] );
                
                $delivery = App\Delivery::create( [
                    'order_id' => $order_id,
                    'title' => $name,
                    'file_id' => $file->id
                ]);               
            }
        }

        return App\Delivery::where('order_id', $order_id )->with('file')->get(); 
    }
}
