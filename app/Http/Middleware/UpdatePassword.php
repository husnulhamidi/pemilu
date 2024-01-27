<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use DateTime;
class UpdatePassword
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
        $check = User::find(auth()->user()->id);
        $now = date('Y-m-d');
        if($check->last_updated!=""){
            $to = \Carbon\Carbon::createFromFormat('Y-m-d', $check->last_updated);
            $from = \Carbon\Carbon::createFromFormat('Y-m-d', $now);
    
            $lastup = $to->diffInDays($from);
        }else{
            $lastup = 32;
        }

        if($lastup>30){
            return redirect('sct/update-password');
        }
        
        return $next($request);

       
    }
}
