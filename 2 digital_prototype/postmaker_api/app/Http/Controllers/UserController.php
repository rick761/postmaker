<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\User;
use App;
use Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;


class UserController extends Controller
{
    //
    function updateUserField(Request $request){                
        $validate = [
            'first_name' => 'sometimes|required', 
            'last_name' => 'sometimes|required', 
            'email' => 'sometimes|required|email|unique:users',                        
            'type' => 'sometimes|required',
            'phone' => 'sometimes|required'
        ];
        $val_msg = [
            'required' => 'Het veld mag niet leeg zijn.',
            'email' => 'Het veld moet een email adres zijn.',
            'unique' => 'Dit :attribute is reeds bestaand.',
        ];
        $attributes = [            
            'email' => 'e-mail',
        ];
        $validator = Validator::make(
            $request->all(),
            $validate,
            $val_msg,
            $attributes);   
        $arr = [];

        if ($validator->fails()) { 
            return response([ 'errors' => $validator->errors() ]);            
        }       
        
        foreach ($request->all() as $key => $value) {
            $arr[$key] = $value;
        }

        $result = $request->user()
                ->update($arr);                      

        return [
            "result" => $result,            
        ];       
    }

    function profile($id, Request $request){
        return App\User::where('id', $id )->first();     
    }

}
