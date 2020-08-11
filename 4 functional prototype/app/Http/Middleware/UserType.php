<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next, $type)
    {
        $userType = Auth::user()->type;
        if($userType != $type){
            return redirect('error');    
        }        
        return $next($request);
    }
}
