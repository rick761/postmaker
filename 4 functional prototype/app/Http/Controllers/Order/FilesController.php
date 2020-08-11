<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App;

class FilesController extends Controller
{
    //
    public function save(Request $request){
        $order_files = $request->order_files;
        $order_id = $request->order_id;
        $order = App\Order::where(['id'=>$order_id, 'user_id' => Auth::id()]);
        $isMyOrder = $order->count();    

        if($isMyOrder){
            $insert = [];
            foreach($order_files as $order_file){                
                array_push($insert, ['url' => $order_file, 'order_id' => $order_id ] );
            }            
            // return $insert;
            return $order->first()->order_files()->insert($insert);
        }        
    }

    public function delete(Request $request, $orderFileId){
        $OrderFile = App\OrderFile::with('order.user')->find($orderFileId);
        $myOrderFile = $OrderFile->order->user->id == Auth::id();
        $orderIncreation = $OrderFile->order->state == 'create';

        if( $myOrderFile  && $orderIncreation ){
            return $OrderFile->delete();
        }        
    }
}
