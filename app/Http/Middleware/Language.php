<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class Language
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
        $locale = App::getLocale();

        if (session()->has('language')) {
            $locale = session('language');
        }

        $language = \App\Language::all()->pluck('slug')->toArray();

        if (!in_array($locale, $language)) {
            $locale = app()->config['app.locale'];
        }

        App::setLocale($locale);
        setlocale(LC_TIME, $locale);

        return $next($request);
    }
}
