<?php

namespace App\Console\Commands;

use App\Activity;
use Illuminate\Console\Command;

class ReviewNotificationCommand extends Command
{
    protected $signature = 'review:notification';

    protected $description = 'Review notification';

    public function handle()
    {
        $activities = Activity::where('status', 'waiting')
            ->whereNull('buyer_mark')
            ->whereRaw("DATE(created_at) = '".(new \DateTime('-2 days'))->format('Y-m-d')."'")
            ->get();

        foreach($activities as $activity){
            $buyer = $activity->buyer;
            $ads = $activity->ads;
            $seller = $activity->seller;
            $notifiableUserProfileActivityUrl = route('profile.show', [$seller->id]);
            $message = '<a href="'
                . $notifiableUserProfileActivityUrl . '">'
                . $seller->name
                . '</a> '
                . trans('translation.confirm_sale.notifications.last_day', [
                    'seller' => $seller->name,
                    'product' => $ads->adsName,
                    'id' => $activity->id,
                    'date' => $activity->created_at,
                    'profileUrl' => $notifiableUserProfileActivityUrl
                ]);
            $picture = [
                'src'  => $seller->avatar,
                'link' => $notifiableUserProfileActivityUrl,
            ];
            $buyer->saveNotification($message, $picture);
        }
    }
}
