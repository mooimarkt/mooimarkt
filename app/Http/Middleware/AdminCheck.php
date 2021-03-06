<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminCheck
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
        if(Auth::check()){
            $user = Auth::user();

            if ($user->userRole == 'admin') {
                return $next($request);
            } else {
                return redirect('/');
                // return redirect('getDashBoardPage');
            }
        } else {
            return redirect('admin');
        }
    }
}
