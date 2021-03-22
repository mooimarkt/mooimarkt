<?php

namespace App\Services;

use App\Option;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payee;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class PaymentPayPal
{
    public $_api_context;

    public function __construct()
    {
        $payPalConf = $this->config();
        $this->_api_context = new ApiContext(new OAuthTokenCredential($payPalConf['client_id'], $payPalConf['secret']));
        $this->_api_context->setConfig($payPalConf['settings']);
    }

    public function payPal($email, $total, $currency = 'EUR')
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item_1 = new Item();
        $item_1->setName('Wallet Up')
            ->setCurrency($currency)
            ->setQuantity(1)
            ->setPrice($total);

        $item_list = new ItemList();
        $item_list->setItems([$item_1]);

        $amount = new Amount();
        $amount->setCurrency($currency)->setTotal($total);

        $payee = new Payee();
        $payee->setEmail($email);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Wallet Up')
            ->setPayee($payee);

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(route('payment_status_pay_pal'))
            ->setCancelUrl(url('/wallet'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions([$transaction]);

        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            return redirect('/wallet');
        }

        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        if (isset($redirect_url)) {
            return redirect($redirect_url);
        }

        return redirect()->back();
    }


    public function paymentStatus($paymentId, $payerId)
    {
        $payment = Payment::get($paymentId, $this->_api_context);

        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);
        $result = $payment->execute($execution, $this->_api_context);

        return $result;
    }

    private function config()
    {
        $config = [
            'client_id' => env('PAYMENT_PAYPAL_CLIENT_ID',''),
            'secret' => env('PAYMENT_PAYPAL_SECRET',''),
            'settings' => array(
                'mode' => env('PAYMENT_PAYPAL_MODE','sandbox'),
                'http.ConnectionTimeOut' => 30,
                'log.LogEnabled' => true,
                'log.FileName' => storage_path() . '/logs/paypal.log',
                'log.LogLevel' => 'ERROR'
            ),
        ];

        $settingPayPal = json_decode(Option::getSetting("opt_payment_paypal"));

        if (!empty($settingPayPal)) {
            $config['client_id'] = $settingPayPal->client_id ?? $config['client_id'];
            $config['secret'] = $settingPayPal->secret ?? $config['secret'];
            $config['settings']['mode'] = $settingPayPal->mode ?? $config['settings']['mode'];
        }

        return $config;
    }
}