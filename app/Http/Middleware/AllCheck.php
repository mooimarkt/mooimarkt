<?php

namespace App\Http\Middleware;

use Closure;

class AllCheck
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
//        $locale = session()->get('locale');
//        \App::setLocale($locale);

        if (!$request->session()->has('forexRate')) {
            $request->session()->put('forexRate', 1);
        }

        if(!$request->session()->has('currency')) {
            $request->session()->put('currency', 'EUR');
        }

        return $next($request);
    }
}
