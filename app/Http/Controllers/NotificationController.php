<?php

namespace App\Http\Controllers;

use App\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $user          = auth()->user();
        $recentNotification = collect($user->getNotifications())->sortByDesc('date')->take(1);
        $user->readNotifications($recentNotification->pluck('id')->toArray());
        $notifications = $recentNotification->toArray();

        $view     = view('site.inc.header-recent-notifications-dropdown', compact('notifications'))->render();
        $viewMore = view('site.inc.header-view-more-notifications-dropdown')->render();

        return response()->json(['success' => true, 'data' => [
            'is_empty'  => empty($notifications),
            'view'      => $view,
            'view_more' => $viewMore,
        ]]);
    }

    public function getNewNotifications()
    {
        $newNotificationsCount = count(auth()->user()->getNewNotifications());

        return response()->json(['success' => true, 'data' => [
            'is_empty'                => empty($newNotificationsCount),
            'new_notifications_count' => $newNotificationsCount,
        ]]);
    }
}
