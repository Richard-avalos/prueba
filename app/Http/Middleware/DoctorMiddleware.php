<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;


class DoctorMiddleware
{
    
    public function handle(Request $request, Closure $next)
    {
        if(auth()->user()->role == 'doctor')
            return $next($request);

        return redirect('/');
    }
}
