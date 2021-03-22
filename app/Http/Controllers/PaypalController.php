<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Validator;
use URL;
use Session;
use Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

/** All Paypal Details class **/

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use App\PackageTransaction;
use App\Pricing;
use App\Ads;
use App\AdsPromo;
use App\Voucher;
use App\VoucherRedeem;
use App\User;
use App\Mail\PublishAdsMail;
use App\PayPal;
use App\PayPalAgreements;


class PaypalController extends Controller
{
    private $_api_context;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //parent::__construct();

        /** setup PayPal api context **/
        $paypal_conf        = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);
    }


    /**
     * Show the application paywith paypalpage.
     *
     * @return \Illuminate\Http\Response
     */
    public function payWithPaypal()
    {
        return view('User/paywithpaypal');
    }

    /**
     * Store a details of payment with paypal.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function postPaymentWithpaypal(Request $request)
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        //dd($request->get("transactionId"));
        $transaction_ID = $request->get("transactionId");
        $transaction    = PackageTransaction::WHERE("referenceId", "=", $transaction_ID)->get();
        $total_amount   = 0;
        foreach ($transaction as $transaction_data) {
            $total_amount += $transaction_data["price"];
        }

        $voucherCode = \Session::get('voucherCode');
        if ($voucherCode) {
            $valid   = 1;
            $voucher = Voucher::WHERE("voucherCode", "=", $voucherCode)->where("status", "=", "1")->first();

            if ($voucher) {
                if ($voucher->multipleRedeem == "no") {
                    $voucher_redeem = VoucherRedeem::WHERE("voucherId", "=", $voucher->id)->where("userId", "=", Auth::user()->id)->get();
                    if ($voucher_redeem) {
                        $valid = 0;
                    }
                }
                if ($valid) {
                    if ($voucher->discountType == "percentage") {
                        $totalDiscount = floor($total_amount * ($voucher->discountValue)) / 100;
                    } else {
                        $totalDiscount = $total_amount - $voucher->discountValue;
                    }
                    $total_amount = $total_amount - $totalDiscount;
                }
            }
        }

        $item_1 = new Item();
        $item_1->setName($request->get('item_name'))/** item name **/
        ->setCurrency("EUR")
            ->setQuantity(1)
            ->setPrice($total_amount);
        /** unit price **/


        $item_list = new ItemList();
        $item_list->setItems(array($item_1));
        $amount = new Amount();
        $amount->setCurrency("EUR")
            ->setTotal($total_amount);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Your transaction description');

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('payment.status'))/** Specify return URL **/
        ->setCancelUrl(URL::route('payment.status'));
        if (!$total_amount) {
            //dd($total_amount);
            Session::put('transaction_ID', $request->get("transactionId"));
            $this->confirm_ads("", $request->get("transactionId"));
            return redirect()->route('activeads', ['btnMethod' => 'publish', 'success' => 'place']);
        }

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        /** dd($payment->create($this->_api_context));exit; **/
        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                \Session::put('error', 'Connection timeout');
                //return Redirect::route('addmoney.paywithpaypal');
                return Redirect::route('paymentPage', ['t_id' => $transaction_ID]);
                /** echo "Exception: " . $ex->getMessage() . PHP_EOL; **/
                /** $err_data = json_decode($ex->getData(), true); **/
                /** exit; **/
            } else {
                \Session::put('error', 'Some error occur, sorry for inconvenient');
                return Redirect::route('paymentPage', ['t_id' => $transaction_ID]);
                //return Redirect::route('addmoney.paywithpaypal');
                /** die('Some error occur, sorry for inconvenient'); **/
            }
        }
        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        Session::put('transaction_ID', $request->get("transactionId"));

        /** add payment ID to session **/
        Session::put('paypal_payment_id', $payment->getId());
        if (isset($redirect_url)) {
            /** redirect to paypal **/
            return Redirect::away($redirect_url);
        }
        \Session::put('error', 'Unknown error occurred');
        //return Redirect::route('addmoney.paywithpaypal');
        return Redirect::route('paymentPage', ['t_id' => $transaction_ID]);
    }

    public function getPaymentStatus()
    {
        /** Get the payment ID before session clear **/
        $payment_id     = Session::get('paypal_payment_id');
        $transaction_ID = Session::get('transaction_ID');
        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');
        Session::forget('transaction_ID');
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            \Session::put('error', 'Payment failed');
            //return Redirect::route('paymentPage?t_id='.$transaction_ID);
            return Redirect::route('paymentPage', ['t_id' => $transaction_ID]);
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        /** PaymentExecution object includes information necessary **/
        /** to execute a PayPal account payment. **/
        /** The payer_id is added to the request query parameters **/
        /** when the user is redirected from paypal back to your site **/
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));
        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);
        /** DEBUG RESULT, remove it later **/
        if ($result->getState() == 'approved') {

            /** it's all right **/
            $totalAmount = $result->transactions[0]->amount->total;
            $currency    = $result->transactions[0]->amount->currency;
            $paymentId   = $result->id;


            $this->confirm_ads($paymentId, $transaction_ID);
            return redirect()->route('activeads', ['btnMethod' => 'publish', 'success' => 'place']);
            //return;
            //dd($transaction);

            /** Here Write your database logic like that insert record or value in database if you want **/
            //\Session::put('success','Payment success');
            //return Redirect::route('getActiveAdsPage?btnMethod=publish&success=place');
            //return Redirect::route('getActiveAdsPage');

        }
        //\Session::put('error','Payment failed');
        return Redirect::route('paymentPage', ['t_id' => $transaction_ID]);
    }

    public function confirm_ads($paymentId, $transaction_ID)
    {

        //$transaction_ID = Session::get('transaction_ID');
        //dd($transaction_ID);
        $voucherCode = Session::get('voucherCode');
        if ($voucherCode) {
            $voucher = Voucher::WHERE("voucherCode", "=", $voucherCode)->where("status", "=", "1")->first();
            if ($voucher) {
                if ($voucher->multipleRedeem == "no") {
                    $voucher_redeem = VoucherRedeem::WHERE("voucherId", "=", $voucher->id)->where("userId", "=", Auth::user()->id)->first();
                    if (!$voucher_redeem) {
                        $redeemRecord                = new VoucherRedeem();
                        $redeemRecord->userId        = Auth::user()->id;
                        $redeemRecord->voucherId     = $voucher->id;
                        $redeemRecord->transactionId = $transaction_ID;
                        $redeemRecord->status        = "1";
                        $redeemRecord->save();
                    }
                } else {
                    $redeemRecord                = new VoucherRedeem();
                    $redeemRecord->userId        = Auth::user()->id;
                    $redeemRecord->voucherId     = $voucher->id;
                    $redeemRecord->transactionId = $transaction_ID;
                    $redeemRecord->status        = "1";
                    $redeemRecord->save();
                }

            }
            \Session::forget('voucherCode');
        }
        //dd($result);
        /* update transaction record */
        $transaction = PackageTransaction::WHERE("referenceId", "=", $transaction_ID)->get();
        foreach ($transaction as $transaction_data) {
            // update transaction table //
            $transaction_data->paymentCode    = $paymentId;
            $transaction_data->paymentChannel = "PayPal";
            $transaction_data->paymentStatus  = "Confirmed";
            $transaction_data->save();

            // process package //
            $package = Pricing::find($transaction_data->packageId);
            $ads     = Ads::find($transaction_data->adsId);
            if (strpos($package->type, "addOn") === false) {
                $package_data = json_decode($package->data, 1);
                if ($package_data["listed"]) {
                    if (strtotime($ads->dueDate) > time()) {
                        $new_ts = strtotime("+ " . $package_data["listed"] . " days", strtotime($ads->dueDate));
                    } else {
                        $new_ts = strtotime("+ " . $package_data["listed"] . " days");
                    }
                    $ads->dueDate        = date("Y-m-d H:i:s", $new_ts);
                    $ads->sortingDate    = date("Y-m-d H:i:s");
                    $ads->adsPlaceMethod = "publish";
                    $ads->adsStatus      = "available";
                    $ads->save();
                }
                if ($package_data["auto-bump"]) {
                    $auto_bump_day = explode(",", $package_data["auto-bump"]);
                    foreach ($auto_bump_day as $i => $days) {
                        AdsPromo::create(['adsId'     => $transaction_data->adsId,
                                          'promoType' => "auto-bump",
                                          'promoDate' => date("Y-m-d H:i:s", strtotime("+ " . $days . " days", time())),
                        ]);
                    }
                }
                if ($package_data["spotlight"]) {
                    for ($i = 0; $i < $package_data["spotlight"]; $i++) {
                        AdsPromo::create(['adsId'     => $transaction_data->adsId,
                                          'promoType' => "spotlight",
                                          'promoDate' => date("Y-m-d H:i:s", strtotime("+ " . $i . " days", time())),
                        ]);
                        if ($i == 0) {
                            $ads->spotlightDate = date("Y-m-d H:i:s");
                            $ads->save();
                        }
                    }
                }
                //if($package_data[""])
            } else {
                $package_data = json_decode($package->data, 1);
                if ($package_data["listed"]) {
                    if (strtotime($ads->dueDate) > time()) {
                        $new_ts = strtotime("+ " . $package_data["listed"] . " days", strtotime($ads->dueDate));
                    } else {
                        $new_ts = strtotime("+ " . $package_data["listed"] . " days");
                    }
                    $ads->dueDate        = date("Y-m-d H:i:s", $new_ts);
                    $ads->adsPlaceMethod = "publish";
                    $ads->adsStatus      = "available";
                    $ads->sortingDate    = date("Y-m-d H:i:s");
                    $ads->save();
                }
                if ($package_data["auto-bump"]) {
                    $auto_bump_day = explode(",", $package_data["auto-bump"]);
                    foreach ($auto_bump_day as $i => $days) {
                        AdsPromo::create(['adsId'     => $transaction_data->adsId,
                                          'promoType' => "auto-bump",
                                          'promoDate' => date("Y-m-d H:i:s", strtotime("+ " . $days . " days", time())),
                        ]);
                    }
                }
                if ($package_data["spotlight"]) {
                    for ($i = 0; $i < $package_data["spotlight"]; $i++) {
                        AdsPromo::create(['adsId'     => $transaction_data->adsId,
                                          'promoType' => "spotlight",
                                          'promoDate' => date("Y-m-d H:i:s", strtotime("+ " . $i . " days", time())),
                        ]);
                        if ($i == 0) {
                            $ads->spotlightDate = date("Y-m-d H:i:s");
                            $ads->save();
                        }
                    }
                }
            }

            $user = User::find($ads->userId);

            $adsId = \Crypt::encryptString($ads->id);

            Mail::to(Auth::user()->email)->send(new PublishAdsMail($user, $ads, $adsId));
            //return redirect()->route('activeads',['btnMethod'=>'publish','success'=>'place']);

        }
    }

    public function agrementRenew(Request $request)
    {


        $res = $request->validate([
            'redir'        => 'required|string',
            'uid'          => 'required|integer',
            'aids'         => 'required|string',
            'old_subscrib' => 'required|string',
        ]);

        $aids   = explode(',', $res['aids']);
        $errors = [];

        if (count($aids) > 0) {

            $paypal = new PayPal();

            foreach ($aids as $aid) {

                $agr = PayPalAgreements::find($aid);

                if (!is_null($agr)) {

                    $agreem = $paypal->ReactivateAgreement($agr->aid);

                    if (is_array($agreem) && key_exists('error', $agreem)) {

                        $errors[] = $agreem['error'];

                        $agr->status = 'renew-error';
                        $agr->save();

                    } else {

                        $agr->status = "active";
                        $agr->save();
                        $agr->User->subscription = $res['old_subscrib'];
                        $agr->User->save();

                    }

                } else {

                    $errors[] = "Your old subscription with id: " . $aid . " not found and not renewed";

                }


            }

            if (count($errors) > 0) {

                return redirect($res['redir'])->withErrors($errors);

            }

        }

        return redirect($res['redir']);

    }

    public function agrementExecute(Request $request)
    {

        $res = $request->validate([
            'redir' => 'required|string',
            'uid'   => 'required|integer',
            'token' => 'required|string',
            'sbs'   => 'required|string',
            'aid'   => 'required|string',
        ]);

        $paypal = new PayPal();

        $agreement = $paypal->ExecuteAgreemen($res['token']);

        if (is_array($agreement) && key_exists('error', $agreement)) {

            return redirect($res['redir'])->withErrors([$agreement['error']]);

        }

        $ppagree = PayPalAgreements::where([
            'uid'    => $res['uid'],
            'aid'    => $res['aid'],
            'status' => 'created'
        ])->first();

        if (!is_null($ppagree)) {

            $ppagree->status = "active";
            $ppagree->aid    = $agreement->getId();
            $ppagree->save();

            if (!is_null($ppagree->User)) {

                $ppagree->User->subscription = $res['sbs'];
                $ppagree->User->save();

            } else {

                return redirect($res['redir'])->withErrors(["user not found"]);

            }

        } else {

            return redirect($res['redir'])->withErrors(["paypal agreement not found"]);

        }


        return redirect($res['redir']);

    }

    public function test()
    {

        $paypal = new PayPal();

        $res = $paypal->ExecuteAgreemen("EC-79P89817U04613300");

        if (is_array($res) && key_exists('error', $res)) {

            dd($res);

        }

        dd($res);

        $agreement = $paypal->CreateAgreement([
            'plan'      => [
                'name'         => "Trader Subscription",
                'description'  => "Trader Subscription Description",
                'amount'       => 10,
                'currency'     => "EUR",
                'subscription' => "Subscription 1",
                'frequency'    => "Month",
                'interval'     => "1",
                'cycles'       => "12",
                'max_fail'     => "10",
                'setup_fee'    => 1,
                'redirect_url' => "",
                'cancel_url'   => "",
            ],
            'agreement' => [
                'name'        => "Basic Agreement",
                'description' => "Basic Agreement",
                'startDate'   => "2019-06-17T9:45:04Z",
            ],
        ]);

        if (is_string($agreement)) {

            dump($agreement);

        } else {

            dump($agreement->getApprovalLink());

        }

    }
}