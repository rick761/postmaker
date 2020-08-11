<?php

namespace App\Http\Controllers;
use App;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    
    public function upload(Request $request){
        $order_id = $request->order_id;
        $isMyOrder = App\Order::where('id', $order_id)->where('user_id',$request->user()->id)->count();
        $newImages = [];
        $allowedfileExtension=['jpg','png'];    

        if (!$isMyOrder) {
            return ['errors' => ['upload' => 'Geen rechten voor het uploaden van een afbeelding.']];
        } ;                           

        if ($request->hasFile('files')){           
            foreach($request->file('files') as $file){ 

               $name = $file->getClientOriginalName();
               $ext= strtolower($file->getClientOriginalExtension()); 

               if( in_array($ext,$allowedfileExtension) ){ // is .ext allowed (.jpg .png)

                    $path = $file->storeAs(
                        'orders/'.$request->user()->id, // directory of user id
                        $name, 
                        'public' // public folder
                    );            
                    
                    $image = App\Image::create( [
                        'order_id' => $order_id,
                        'url' => $path,
                    ] );

                    array_push($newImages,$image);                                       
                }                              
            }             
            return $newImages;            
        }
       
        return ['errors' => ['upload' => 'Er is geen bestand geupload.']];
    }

    public function delete(Request $request){
        $img = App\Image::where( 'id', $request->input('id') )->with('order.user')->first();

        $isMine = ( $img->order->user->id == Auth::id() );
        
        if($isMine){
            return $img->delete();
        }
        
        return ['errors' => ['delete' => 'Kan geen image deleten'] ];        

    }

}
