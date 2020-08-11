<?php

namespace App\Http\Controllers;

use App\User; 
use Validator;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Laravel\Passport\Client as OClient; 
use Laravel\Passport\HasApiTokens;

class ApiController extends Controller
{
    public $successStatus = 200;

    public function login(Request $request) { 
        
        $validator = Validator::make($request->all(), [
            'email' => 'email|required', 
            'password' => 'required'             
        ]);

         if ($validator->fails()) { 
            return response()->json(['errors' => ['message'=>'Foute invoer.']]);            
         }

        if (!auth()->attempt($request->all())) {
            return response(['errors' => ['message'=>'Foute Login.']]);
        }
        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        return response(['access_token' => $accessToken]);

    }

    public function register(Request $request) { 
        

        $validator = Validator::make($request->all(), [ 
            'first_name' => 'required', 
            'last_name' => 'required', 
            'email' => 'required|email|unique:users', 
            'password' => 'required', 
            'c_password' => 'required|same:password', 
            'type' => 'required'
        ]);      

        if ($validator->fails()) {             
            return response([ 'errors' => $validator->errors() ]);            
        }

        $request->password = bcrypt($request->password);
        $input = $request->all();         
        $user = User::create($input); 
        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['access_token' => $accessToken]);

    }

    public function logout(){   

        if (Auth::check()) {
            return Auth::user()->token()->revoke();           
        }

        return 'No authentication to log out with';
    }
    
}
