<?php

namespace App\Http\Controllers\user;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;

use Mollie\Laravel\Facades\Mollie;
use Auth;
use App\User;


class MollieAPI extends BaseController
{
    // public function  __construct() {
    //     // dd(env('MOLLIE_KEY'));
    //     //Mollie::api()->setApiKpuey(env('MOLLIE_KEY')); // your mollie test api key
    // }
    public function preparePayment(Request $request)
    {
        if (!isset($request->amount) || (int)$request->amount <= 0) {
            return redirect()->back();
        }
        $payamount  = number_format((float)$request->amount,2);
        $user       = auth()->user();
        $payment    = Mollie::api()->payments()->create([
            "amount" => [
                "currency" => "EUR",
                "value" => (string)$payamount,
            ],
            "description" => "Mooimarkt Subscription Fee",
            "redirectUrl" => route('payment_mollie_success'),
            // "webhookUrl" => "http://mooimarkt/",//route('webhooks.mollie'),
            "metadata" => [
                "user_id" => $user->id,
                "email" => $user->email,
                "name"=>$user->name.' '.$user->lname
            ],
        ]);
        session()->put('p_mollie_id', $payment->id);
        $payment = Mollie::api()->payments()->get($payment->id);
        // redirect customer to Mollie checkout page
        return redirect($payment->getCheckoutUrl(), 303);
    }

    public function handleWebhookNotification(Request $request) {
        $payment = Mollie::api()->payments()->get(session()->get('p_mollie_id'));
        $user_id = Auth::user()->id;
        // $user = User::find($user_id);

        if ($payment->isPaid())
        {
            // dd($payment);
            // echo 'Payment received.';
            $user = auth()->user();
            $user->transactions()->create([
                'method' => 'Mollie('.$payment->method.')',
                'transaction_id' => $payment->id,
                'currency' => $payment->amount->currency,
                'total' => $payment->amount->value,
                'email' => isset($payment->details->consumerAccount)? $payment->details->consumerAccount:NULL,
                'response'=>json_encode($payment->details),
                'type' => 'payment',
                'status' => 'success'
            ]);

            $user->increment('wallet', $payment->amount->value);
            return redirect('/#success')->with('success', 'Success!');
            // Do your thing ...
        }else{
            $user = auth()->user();
            $user->transactions()->create([
                'method' => 'Mollie('.$payment->method.')',
                'transaction_id' => $payment->id,
                'currency' => $payment->amount->currency,
                'total' => $payment->amount->value,
                'email' => isset($payment->details->consumerAccount)? $payment->details->consumerAccount:NULL,
                'response'=>json_encode($payment->details),
                'type' => 'payment',
                'status' => 'no_register'
            ]);
            return redirect('/#error')->with('error', 'Error!');
        }
    }
}
