<?php

namespace App\Services;

use App\Option;
use Cartalyst\Stripe\Stripe;

class StripePayout
{
    public $config;
    public $stripe;
    public $card_number;
    public $card_month;
    public $card_year;
    public $card_cvc;
    public $customer_email;
    public $amount;
    public $currency;

    function __construct($customer_email = null, $card_number = null, $card_month = null, $card_year = null, $card_cvc = null, $amount = null, $currency = null)
    {
        $this->config         = $this->config();
        $this->stripe         = new Stripe($this->config['secret'], $this->config['version']);
        $this->customer_email = $customer_email;
        $this->card_number    = $card_number;
        $this->card_month     = $card_month;
        $this->card_year      = $card_year;
        $this->card_cvc       = $card_cvc;
        $this->amount         = $amount;
        $this->currency       = $currency;
    }

    public function card_payout($userDetail)
    {
        try {
            // test card - 4000 0566 5566 5556

            $cardToken = $this->stripe->tokens()->create([
                'card' => [
                    'number'    => $this->card_number,
                    'exp_month' => $this->card_month,
                    'exp_year'  => $this->card_year,
                    'cvc'       => $this->card_cvc,
                    'currency'  => $this->currency,
                ],
            ]);

            $account = $this->stripe->account()->create([
                'country'                => 'US',
                'type'                   => 'custom',
                'requested_capabilities' => ['legacy_payments'],
                'external_account'       => $cardToken['id'],
                'business_type'          => 'individual',
                'individual'             => [
                    'first_name' => $userDetail['first_name'],
                    'last_name'  => $userDetail['last_name'],
                    'dob'        => [
                        'day'   => $userDetail['day'],
                        'month' => $userDetail['month'],
                        'year'  => $userDetail['year']
                    ]
                ]
                //            'requested_capabilities' => ['card_payments', 'transfers'],
            ]);

            $this->stripe->account()->update(
                $account['id'], [
                    'tos_acceptance' => [
                        'date' => time(),
                        'ip'   => $_SERVER['REMOTE_ADDR']
                    ]
                ]
            );

            $transfer = $this->stripe->transfers()->create([
                'amount'      => $this->amount,
                'currency'    => $this->currency,
                'destination' => $account['id'],
                #'transfer_group' => 'ORDER_95',
            ]);

            return [
                'status'   => true,
                'account'  => $account,
                'transfer' => $transfer,
            ];

        } catch (\Exception $exception) {
            return [
                'status'  => false,
                'message' => $exception->getMessage(),
            ];
        }
    }

    private function config()
    {
        $config = [
            'version' => env('PAYOUT_STRIPE_VERSION', '2019-02-19'),
            'secret'  => env('PAYOUT_STRIPE_SECRET', '')
        ];

        $settingStripe = json_decode(Option::getSetting("opt_payout_stripe"));

        if (!empty($settingStripe)) {
            $config['secret'] = $settingStripe->secret ?? $config['secret'];
        }

        return $config;
    }
}

