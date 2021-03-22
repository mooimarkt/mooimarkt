<?php

namespace App\Console\Commands;

use App\Transaction;
use Illuminate\Console\Command;

class CheckPayoutsPayPal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payouts:check_pay_pal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Payouts PayPal';

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
        $payouts = Transaction::where('type', 'payout')
            ->where('method', 'PayPal')
            ->whereIn('status', ['pending', 'no_register'])
            ->get();

        Transaction::updateStatusPayoutsPayPal($payouts);
    }
}
