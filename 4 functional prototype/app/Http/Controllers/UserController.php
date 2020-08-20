<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App;

class UserController extends Controller
{
    function get(Request $request, $id){
        return App\User::with('user_images')->withCount('user_likes')->find($id);
    }


    function profile(Request $request){
        $me = App\User::with('user_images')->withCount('user_likes')->find(Auth::id());
        $me = $me->makeVisible(['first_name', 'last_name', 'phone']);
        return $me;
    }

    function updateProfile(Request $request){        
                          
        if($request->user_images){                 
            $this->saveUserImages($request->user_images);    
        }             

        //validate display name;
        if($request->display_name){
            $getDisplayNameUser = App\User::where('display_name' , $request->display_name);
            $exists = $getDisplayNameUser->count();
            $isMe = $getDisplayNameUser->first()->id == Auth::id();            
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
        return $me->save();                     
    }

    private function saveUserImages($list = null){    

        $me = Auth::User();
        $count = 0;        
        foreach($list as $user_image){     
            $exists = App\UserImage::where( ['user_id' => Auth::id(), 'url'=> $user_image['url'] ] )->count();      
            if(!$exists){
                $image = new App\UserImage($user_image);   
                $me->user_images()->save($image);
                $count++;
            }                
        }
        return $count;
    }

    public function deleteUserImage ( Request $request ){     

        $deletedRows = App\UserImage::where([ 'url' => $request->url, 'user_id' => Auth::id() ])->delete(); 

        return $deletedRows;

    }

    // saveUserImages

}
