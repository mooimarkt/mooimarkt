<?php

namespace App\Http\Middleware;

use App\Category;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Chat;

class CommonVariables
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

        View::share('mainCategories', Category::with(['subCategories', 'subCategories.adsFilters', 'subCategories.adsFilters.children'])->orderBy('categoryStatus')->get());
        View::share('optLinkFacebook', \App\Option::getSetting("opt_link_facebook"));

        View::share('optLinkInstagram', \App\Option::getSetting("opt_link_instagram"));

        View::share('authUser', Auth::user());

        if (Auth::check()) {
            $notifications = Auth::user()->getNotifications();
            $newNotifications = collect($notifications)->where('read', 0)->count();

            View::share('newNotifications', $newNotifications);

			$unreadMessagesCount = Chat::messages()->setUser(auth()->user())->unreadCount();
			View::share('unreadMessagesCount', $unreadMessagesCount);
        }

        return $next($request);
    }
}
