<?php

namespace App\Services;

use App\Option;
use Cartalyst\Stripe\Stripe;

class StripePayment
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
        $this->config = $this->config();
        $this->stripe = new Stripe($this->config['secret'], $this->config['version']);
        $this->customer_email = $customer_email;
        $this->card_number = $card_number;
        $this->card_month = $card_month;
        $this->card_year = $card_year;
        $this->card_cvc = $card_cvc;
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function card_payment()
    {
        try {
            // Creating temporary user
            $customer = $this->stripe->customers()->create([
                'email' => $this->customer_email,
            ]);

            // Creating temporary card
            $token = $this->stripe->tokens()->create([
                'card' => [
                    'number'    => $this->card_number,
                    'exp_month' => $this->card_month,
                    'exp_year'  => $this->card_year,
                    'cvc'       => $this->card_cvc,
                ],
            ]);

            // Need add temporary card to customer
            $this->stripe->cards()->create($customer['id'], $token['id']);

            $charge = $this->stripe->charges()->create([
                'customer' => $customer['id'],
                'currency' => $this->currency,
                'amount'   => $this->amount,
            ]);

            if (isset($charge['status']) and $charge['status'] == 'succeeded') {
                return [
                    'status' => true,
                    'charge' => $charge,
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Error Payment!',
                ];
            }
        } catch (\Exception $exception) {
            return [
                'status' => false,
                'message' => $exception->getMessage(),
            ];
        }
    }

    public function refund($charge_id)
    {
        return $this->stripe->refunds()->create($charge_id);
    }

    private function config()
    {
        $config = [
            'version' => env('PAYMENT_STRIPE_VERSION','2019-02-19'),
            'secret' => env('PAYMENT_STRIPE_SECRET','')
        ];

        $settingStripe = json_decode(Option::getSetting("opt_payment_stripe"));

        if (!empty($settingStripe)) {
            $config['secret'] = $settingStripe->secret ?? $config['secret'];
        }

        return $config;
    }
}

