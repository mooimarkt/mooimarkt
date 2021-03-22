<?php

namespace App\Services;

use App\Option;
use PayPal\Api\Payout;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPal\Api\PayoutSenderBatchHeader;
use PayPal\Api\PayoutItem;
use PayPal\Api\Currency;

class PayoutPayPal
{
    public $_api_context;

    public function __construct()
    {
        $payPalConf = $this->config();
        $this->_api_context = new ApiContext(new OAuthTokenCredential($payPalConf['client_id'], $payPalConf['secret']));
        $this->_api_context->setConfig($payPalConf['settings']);
    }

    public function payout($email, $total, $currency = 'EUR')
    {
        $payouts = new Payout();
        $senderBatchHeader = new PayoutSenderBatchHeader();
        $senderBatchHeader->setSenderBatchId(uniqid().microtime(true))
            ->setEmailSubject("You have a payment");

        $senderItem = new PayoutItem();
        $senderItem->setRecipientType('Email')
            ->setNote('Thanks you.')
            ->setReceiver($email)
            ->setSenderItemId("item_" . uniqid().microtime('true'))
            ->setAmount(new Currency('{
                    "value":"'.$total.'",
                    "currency":"'.$currency.'"
                }'));
        $payouts->setSenderBatchHeader($senderBatchHeader)->addItem($senderItem);

        try {
            $output = $payouts->create(array('sync_mode' => 'false'), $this->_api_context);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            return false;
        }

        return $output;
    }

    public function getPayoutsDetail($payoutBatchId)
    {
        $payouts = new Payout();
        return $payouts->get($payoutBatchId, $this->_api_context);
    }

    private function config()
    {
        $config = [
            'client_id' => env('PAYOUT_PAYPAL_CLIENT_ID',''),
            'secret' => env('PAYOUT_PAYPAL_SECRET',''),
            'settings' => array(
                'mode' => env('PAYOUT_PAYPAL_MODE','sandbox'),
                'http.ConnectionTimeOut' => 30,
                'log.LogEnabled' => true,
                'log.FileName' => storage_path() . '/logs/paypal.log',
                'log.LogLevel' => 'ERROR'
            ),
        ];

        $settingPayPal = json_decode(Option::getSetting("opt_payout_paypal"));

        if (!empty($settingPayPal)) {
            $config['client_id'] = $settingPayPal->client_id ?? $config['client_id'];
            $config['secret'] = $settingPayPal->secret ?? $config['secret'];
            $config['settings']['mode'] = $settingPayPal->mode ?? $config['settings']['mode'];
        }

        return $config;
    }
}