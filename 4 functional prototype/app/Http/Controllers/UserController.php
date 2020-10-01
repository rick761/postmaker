<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App;
use App\User;
use App\UserImage;
use App\Order;

class UserController extends Controller
{

    function get($id){
        return User::with([
                'user_images',
                'user_show_deliverys.order_delivery_file.order_delivery'
            ])
            ->withCount('user_likes')
            ->find($id);
    }


    function profile(){
        $me = User::with([
            'user_images',
            'user_show_deliverys.order_delivery_file.order_delivery'
        ])
        ->withCount('user_likes')
        ->find(Auth::id());

        $me = $me->makeVisible([
            'first_name', 
            'last_name',
            'phone'
        ]);

        return $me;
    }

    function updateProfile(Request $request){        
        
        if($request->user_images){                 
            $this->saveUserImages($request->user_images);    
        }             

        //validate display name;
        if($request->display_name){
            $getDisplayNameUser = User::where('display_name' , $request->display_name);
            $exists = $getDisplayNameUser->count();
            $isMe = 0;

            if( !empty( $getDisplayNameUser->first() ) ){
                $isMe = $getDisplayNameUser->first()->id == Auth::id();   
            }         

            if($exists && !$isMe) return 'Naam is al in gebruik';
        }
       

        $me = Auth::user();        
        if($request->first_name){$me->first_name = $request->first_name;}
        if($request->last_name){$me->last_name = $request->last_name;}
        if($request->avatar){$me->avatar = $request->avatar;}
        if($request->description){$me->description = $request->description;}
        if($request->display_name){$me->display_name = $request->display_name;}
        if($request->company){$me->company = $request->company;}
        if($request->website){$me->website = $request->website;}
        if($request->phone){$me->phone = $request->phone;}
        $me->save();
        
        return [$request->all(),$me];
    }

    private function saveUserImages($list = null){   
        $me = Auth::User();
        $count = 0;      

        foreach($list as $user_image){     

            $exists = UserImage::where([
                'user_id' => Auth::id(), 
                'url'=> $user_image['url'] 
            ])->count();      

            if(!$exists){
                $image = new UserImage($user_image);   
                $me->user_images()->save($image);
                $count++;
            }                
        }
        return $count;
    }


    public function deleteUserImage ( Request $request ){     
        $deletedRows = UserImage::where([
            'url' => $request->url, 
            'user_id' => Auth::id() 
        ])->delete(); 

        return $deletedRows;
    }


    public function setShowFiles(Request $request){       
        $order_id = $request->order_id;
        $order = Order::with('order_deliveries.order_delivery_files')->find($order_id);

        //deleteOld
        foreach($order->order_deliveries as $delivery){
            foreach($delivery->order_delivery_files as $file){
                $showing_deliveries = $file->user_show_deliverys()->where('user_id',Auth::id())->get();
                foreach($showing_deliveries as $showing_delivery){
                    $showing_delivery->delete();
                }
            }
        }

        //createNew      
        foreach($request->delivery_files as $delivery_file){    
            Auth::user()->user_show_deliverys()->firstOrCreate([
                'order_delivery_file_id' => $delivery_file['id']
            ]);
        }

        return Auth::user()->user_show_deliverys()->with('order_delivery_file.order_delivery')->get();
    }

    public function hideShowFiles (Request $request){ 
        $order_id = $request->order_id;
        $order = Order::with('order_deliveries.order_delivery_files')->find($order_id);
        
        foreach($order->order_deliveries as $delivery){
            foreach($delivery->order_delivery_files as $file){
                $showing_deliveries = $file->user_show_deliverys()->where('user_id',Auth::id())->get();
                foreach($showing_deliveries as $showing_delivery){
                    $showing_delivery->delete();
                }
            }
        }    
    }


}
