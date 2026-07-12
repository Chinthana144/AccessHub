<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class ResetMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /*
        * create a session named "reset_user" and check middleware from it.
        */
        if(!Session::get('reset_user'))
        {
            return redirect()->route('reset.index')->with('error', 'Please login!'); 
        }

        return $next($request);
    }
}
