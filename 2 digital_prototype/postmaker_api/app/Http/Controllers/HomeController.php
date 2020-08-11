<?php

namespace App\Http\Controllers;
use App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $openOrders = App\Order::with('user')     
            ->where('postmaker_id','=',null)   
            ->get();    

        $profileType = Auth::user()->type;

        if($profileType == 'Postmaker'){
            $myOrders = App\Order::with('user')      
                ->where('postmaker_id', Auth::user()->id )   
                ->get();      
        }
        
        if($profileType == 'Contentaanvrager'){
            $myOrders = App\Order::with('user')      
                ->where('user_id', Auth::user()->id )   
                ->get();      
        }

        return view('home',[            
            'openOrders' => $openOrders,
            'myOrders' => $myOrders
        ]);
    }
}
