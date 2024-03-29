<?php

namespace App\Http\Middleware;

use Closure;

class PermissionAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        if(auth()->user()->role_id!=1){
            return redirect('/notfound');
        }
        
        return $next($request);

       
    }
}
