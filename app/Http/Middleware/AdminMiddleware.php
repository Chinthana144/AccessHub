<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //check user id
        $user_id = Auth::id();
        $user = User::find($user_id);
        if($user->email != 'chinthana144@gmail.com')
        {
            return redirect()->view('auth.login');
        }

        return $next($request);
    }
}
