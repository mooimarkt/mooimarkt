<?php

namespace App;

use App\Services\PayoutPayPal;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public static function updateStatusPayoutsPayPal($payouts = [])
    {
        $payoutPayPal = new PayoutPayPal();

        foreach ($payouts as $payout) {
            $payoutDetail = $payoutPayPal->getPayoutsDetail($payout->transaction_id);
            $payoutStatus = $payoutDetail->getItems()[0]->transaction_status;

            switch ($payoutStatus) {
                case 'SUCCESS':
                    $payout->update([
                        'status' => 'success',
                        'email' => $payoutDetail->getItems()[0]->getPayoutItem()->receiver
                    ]);
                    break;
                case 'UNCLAIMED':
                    $payout->update([
                        'status' => 'no_register',
                        'email' => $payoutDetail->getItems()[0]->getPayoutItem()->receiver
                    ]);
                    break;
                case 'REFUNDED':
                case 'RETURNED':
                case 'REVERSED':
                case 'FAILED':
                    $payout->update([
                        'status' => 'canceled',
                        'email' => $payoutDetail->getItems()[0]->getPayoutItem()->receiver
                    ]);
                    $payout->user()->increment('wallet', $payout->total);
                    break;
            }
        }
    }

}
