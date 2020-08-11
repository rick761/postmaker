<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App;

class OrderController extends Controller
{
    public function open(Request $request){       //all open orders (not to view!)  
        $orders = App\Order::with('user')
            ->where('state','open')
            ->orderBy('deliver', 'asc')
            ->with(['images','user','postmaker'])
            ->get();
        return json_encode(['orders_open'=>$orders]);
    }

    public function postmaker(Request $request){
        $orders = App\Order::where('postmaker_id', $request->user()->id )
            ->where('state','<>','archive')
            ->with(['images','user','postmaker'])
            ->orderBy('deliver', 'asc')
            ->with('images')
            ->get();
        return json_encode( ['orders_postmaker'=>$orders] );
    }

    public function contentaanvrager(Request $request){
        $orders = App\Order::where( 'user_id', $request->user()->id )
        ->with(['images','user','postmaker'])
        ->where('state','<>','archive')
        ->orderBy('deliver', 'asc')
        ->get();

        return json_encode([ 'orders_contentaanvrager' => $orders ]);
    }    

    public function requested(Request $request){
        $user_id = $request->user()->id;

        $orders_as_postmaker = App\Order::whereHas( 'requests', function(Builder $query) use ($user_id){
            return $query->where('postmaker_id', '=', $user_id );
        })                
        ->where('state','open')
        ->with(['images','requests'])
        ->orderBy('deliver', 'asc')
        ->get();

        $orders_as_requested = App\Order::whereHas( 'requests', function(Builder $query) use ($user_id){
            return $query->where('user_id', '=', $user_id );
        })

        ->where('state','open')
        ->with(['images','requests'])
        ->orderBy('deliver', 'asc')
        ->get();

        $merged = $orders_as_postmaker->merge($orders_as_requested);

        return json_encode([ 'orders_requested' => $merged ]);
    }

    public function archived(Request $request){
        $user_type = $request->user()->type;
        $orders = "";

        if($user_type == 'Contentaanvrager'){
            $orders = App\Order::where( 'state', 'archive' )->where( 'user_id', $request->user()->id )->with(['deliverys'])->get(); ;
        }
        if($user_type == 'Postmaker'){
            $orders = App\Order::where( 'state', 'archive' )->where( 'postmaker_id', $request->user()->id )->with(['deliverys'])->get();            
        }          
        
        return json_encode([ 'orders_archived' => $orders ]);
    }

    public function view($id){
        $order = App\Order::where('id', $id )
            ->with(['user','images','postmaker','comments','messages','requests.postmaker','deliverys.file'])        
            ->first();         

        return $order;
    }
    public function save(Request $request ){    
            
        $order = App\Order::where([
            'id' => $request->input('id'),
            'user_id' => Auth::id()
        ]);

        if(!$order->count()){
            return response([ 'errors' => ['save' => 'Kan niet updaten.'] ]);
        }

        return $order->update($request->all());
    }

    public function postmakerState(Request $request ){

        $order = App\Order::where([
            'id' => $request->input('id'),
            'postmaker_id' => Auth::id()
        ]);
        
        /**Notification**/
        $title  =  $order->first()->title;
        $uName =  $request->user()->first_name;        
        $m = "";
        if($request->postmaker_state == "stop"){        $m = $uName." Wilt stoppen met ".$title.".";  }
        if($request->postmaker_state == "delivered"){   $m = $uName." Heeft een oplevering gedaan voor ".$title."."; }
        if($request->postmaker_state == "in_progress"){ $m = $uName." Is ".$title." aan het maken."; }
        if($request->postmaker_state == "payed"){       $m = $uName." Heeft een betaling ontvangen voor ".$title."."; }
        $newNotification = App\Notification::create([
            'user_id' => $order->first()->user_id,
            'message' => $m,
            'url' => 'order/'.$request->input('id')
        ]);        
        event(new App\Events\newNotification($newNotification));
        /**endNotification**/

        return $order->update(['postmaker_state' => $request->postmaker_state]);
        
    }

    public function state(Request $request ){
        //return $request->all();
        $order = App\Order::where([
            'id' => $request->input('id'),
            'user_id' => Auth::id()
        ]);  

        if(!$order->count()){
            return ['errors'=> ['state' => 'Geen rechten om de status te veranderen.' ]] ;
        }

        $hasPostmaker = $order->with('postmaker')->first()->postmaker;    

        switch($request->state){
            case 'create': 
                if($hasPostmaker){
                    return ['errors'=> ['state' => 'kan niet naar deze status als er een postmaker is.' ]] ;
                }
            break;

            case 'open':
                if(empty($order->first()->title)){
                    return ['errors'=> ['state' => 'Kan de order niet openbaar zetten als er geen titel is.' ]] ;
                }
                if($hasPostmaker){
                    return ['errors'=> ['state' => 'kan niet naar deze status als er een postmaker is.' ]] ;
                }
            break;

            case 'in_progress': 
            case 'denied': 
            case 'accepted': 
            case 'payed':
                if(! $hasPostmaker){
                    return ['errors'=> ['state' => 'kan niet naar deze status als er geen postmaker is.' ]] ;
                }
            break;
        }

        /**Notification**/
        if($order->first()->postmaker_id){
            $title  =  $order->first()->title;
            $uName =  $request->user()->first_name;        
            $m = "";        
            if($request->state == "declined"){      $m = $uName." heeft een oplevering afgewezen voor ".$title."."; }
            if($request->state == "in_progress"){   $m = $uName." wacht op content voor ".$title."."; }
            if($request->state == "accepted"){       $m = $uName." Heeft de oplevering geaccepteerd voor ".$title."."; }
            if($request->state == "stop"){        $m = $uName." Heeft aangegeven te willen stoppen met ".$title."."; }
            if($request->state == "payed"){        $m = $uName." Heeft de een betaling gedaan voor ".$title."."; }
            $newNotification = App\Notification::create([
                'user_id' => $order->first()->postmaker_id,
                'message' => $m,
                'url' => 'order/'.$request->input('id')
            ]);        
            event(new App\Events\newNotification($newNotification));
        }
        /**endNotification**/

        return $order->update(['state' => $request->state]);
    }


    public function create(Request $request){
        $order = new App\Order;

        $order->user_id = $request->user()->id;

        $order->save();

        return $order;
    }


}
