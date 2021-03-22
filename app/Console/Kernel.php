<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\cronEmail',
        'App\Console\Commands\cronEmailWeekly',
        'App\Console\Commands\GenerateSitemap',
        'App\Console\Commands\PayoutsPayPal',
        'App\Console\Commands\CheckPayoutsPayPal',
        'App\Console\Commands\ReviewNotificationCommand',
        'App\Console\Commands\ReviewAutoConfirmCommand',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('sitemap:generate')
                 ->daily();

        $schedule->command('payouts:check_pay_pal')
            ->twiceDaily(1, 13);

        $schedule->command('payouts:pay_pal')
            ->everyTenMinutes();

        $schedule->command('review:notification')
            ->dailyAt('10:00');

        $schedule->command('review:auto-confirm')
            ->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
