<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class cronEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:cronemail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        app('App\Http\Controllers\AdsController')->cronSendCompleteAdsMail();
        app('App\Http\Controllers\AdsController')->cronSendExpireMail();
        app('App\Http\Controllers\User\SearchAlertController')->cronSendSearchAlertMail(1);
    }
}
