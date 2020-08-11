<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App;

class UserController extends Controller
{
    //
    function profile(Request $request){

        return App\User::with('user_images')->find(Auth::id());
    }

    function updateProfile(Request $request){
        $me = App\User::where('id',Auth::id());
        return $me->update($request->toArray());        
    }
}
