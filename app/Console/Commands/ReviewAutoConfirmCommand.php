<?php

namespace App\Console\Commands;

use App\Activity;
use Illuminate\Console\Command;

class ReviewAutoConfirmCommand extends Command
{
    protected $signature = 'review:auto-confirm';

    protected $description = 'Review auto confirm';

    public function handle()
    {
        $activities = Activity::where('status', 'waiting')
            ->whereNull('buyer_mark')
            ->whereRaw("created_at < '".(new \DateTime('-3 days'))->format('Y-m-d H:i:s')."'")
            ->get();

        foreach($activities as $activity){
            $activity->update([
                'status' => 'success',
            ]);
        }
    }
}
