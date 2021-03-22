<?php

namespace App\Console\Commands;

use App\Services\PaymentPayPal;
use App\Transaction;
use Illuminate\Console\Command;

class PayoutsPayPal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payouts:pay_pal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Payouts PayPal';

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
            ->where('status', 'pending')
            ->get();

        Transaction::updateStatusPayoutsPayPal($payouts);
    }
}
