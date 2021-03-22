<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller as BaseController;
use App\Services\PayoutPayPal;
use App\Services\StripePayment;
use App\Services\PaymentPayPal;

use App\Services\StripePayout;
use Illuminate\Http\Request;
use App\Http\Requests\CreditCardPaymentRequest;
use App\Http\Requests\CreditCardPayoutRequest;
use App\Http\Requests\PayoutPayPalRequest;
use App\Transaction;

class WalletController extends BaseController
{
    public function walletUp(Request $request)
    {
        $user = auth()->user();
        // $transactions = $user->transactions;
        $transactions = Transaction::where('userId',$user->id)->orderBy('id', 'DESC')->get();

        return view('site.pages.wallet-up', compact('transactions'));
    }

    public function walletOut(Request $request)
    {
        if (!isset($request->amount) || (int)$request->amount <= 0) {
            abort(404);
        }

        return view('site.pages.wallet-out');
    }

    public function walletHistory()
    {
        $user = auth()->user();
        $transactions = $user->transactions;

        return view('site.pages.wallet-history', compact('transactions'));
    }


    public function paymentCard(CreditCardPaymentRequest $request)
    {
        $user = auth()->user();

        $data = [
            'currency' => 'EUR',
            'email' => $user->email,
            'amount' => $request->amount,
        ];

        $stripe_payment = new StripePayment(
            $data['email'],
            $request->card_number,
            $request->card_month,
            $request->card_year,
            $request->card_cvv,
            $data['amount'],
            $data['currency']
        );

        $result = $stripe_payment->card_payment();

        if ($result['status']) {
            $user->transactions()->create([
                'method' => 'Stripe',
                'transaction_id' => $result['charge']['id'],
                'currency' => $data['currency'],
                'total' => $data['amount'],
                'type' => 'payment',
                'email' => $data['email'],
                'status' => 'success'
            ]);

            $user->increment('wallet', $data['amount']);

            $response = $this->formatResponse('success', 'Payment successfully completed!');
        } else {
            $response = $this->formatResponse('error_payment', $result['message']);
        }

        return response($response, 200);
    }

    public function paymentPayPal(Request $request)
    {
        if (!isset($request->amount) || (int)$request->amount <= 0) {
            return redirect()->back();
        }

        $user = auth()->user();

        $data = [
            'currency' => 'USD',
            'email' => $user->email,
            'amount' => $request->amount,
        ];

        $paymentPayPal = new PaymentPayPal();

        return $paymentPayPal->payPal($data['email'], $data['amount'], $data['currency']);
    }

    public function paymentStatusPayPal(Request $request)
    {
        if (!isset($request->paymentId) || !isset($request->PayerID) || !isset($request->token)) {
            return redirect('/#error');
        }
        $paymentPayPal = new PaymentPayPal();
        $result = $paymentPayPal->paymentStatus($request->paymentId, $request->PayerID);

        if ($result->getState() == 'approved') {
            $user = auth()->user();
            $user->transactions()->create([
                'method' => 'PayPal',
                'transaction_id' => $result->getId(),
                'currency' => $result->getTransactions()[0]->getAmount()->getCurrency(),
                'total' => $result->getTransactions()[0]->getAmount()->getTotal(),
                'email' => $result->getPayer()->getPayerInfo()->email,
                'type' => 'payment',
                'status' => 'success'
            ]);

            $user->increment('wallet', $result->getTransactions()[0]->getAmount()->getTotal());

            return redirect('/#success')->with('success', 'Success!');
        }

        return redirect('/#error')->with('error', 'Error!');
    }




    public function payoutCard(CreditCardPayoutRequest $request)
    {
        $user = auth()->user();
        $userWallet = (int)$user->wallet;

        if ($userWallet < $request->amount || $user->transactions_wallet_sum < $request->amount) {
            $response = $this->formatResponse('error_balance', 'Insufficient balance!');
            return response($response, 200);
        }

        $dateBirth = explode('/', $request->date_birth);

        $data = [
            'currency' => 'EUR',
            'email' => $user->email,
            'amount' => $request->amount,
        ];

        $stripe_payment = new StripePayout(
            $data['email'],
            $request->card_number,
            $request->card_month,
            $request->card_year,
            $request->card_cvv,
            $data['amount'],
            $data['currency']
        );

        $result = $stripe_payment->card_payout([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'day' => $dateBirth[0],
            'month' => $dateBirth[1],
            'year' => $dateBirth[2],
        ]);


        if ($result['status']) {
            $user->transactions()->create([
                'method' => 'Stripe',
                'transaction_id' => $result['transfer']['id'],
                'currency' => $data['currency'],
                'total' => $data['amount'],
                'type' => 'payout',
                'email' => $data['email'],
                'status' => 'success'
            ]);

            $user->decrement('wallet', $data['amount']);
            $response = $this->formatResponse('success', 'Payment in processing!');
        } else {
            $response = $this->formatResponse('error_payout', $result['message']);
        }

        return response($response, 200);
    }


    public function payoutPayPal(PayoutPayPalRequest $request)
    {
        $user = auth()->user();
        $userWallet = (int)$user->wallet;

        if ($userWallet < $request->amount || $user->transactions_wallet_sum < $request->amount) {
            $response = $this->formatResponse('error_balance', 'Insufficient balance!');
            return response($response, 200);
        }

        $data = [
            'currency' => 'USD',
            'email' => $request->email,
            'amount' => $request->amount,
        ];

        $payoutPayPal = new PayoutPayPal();
//        dd($payoutPayPal);

        $result = $payoutPayPal->payout($data['email'], $data['amount'], $data['currency']);

        if ($result) {
            $payoutsDetail = $payoutPayPal->getPayoutsDetail($result->getBatchHeader()->getPayoutBatchId());

            $user->transactions()->create([
                'method' => 'PayPal',
                'transaction_id' => $payoutsDetail->getBatchHeader()->getPayoutBatchId(),
                'email' => $payoutsDetail->getItems()[0]->getPayoutItem()->receiver,
                'currency' => $payoutsDetail->getBatchHeader()->getAmount()->getCurrency(),
                'total' => $payoutsDetail->getBatchHeader()->getAmount()->getValue(),
                'type' => 'payout',
                'status' => 'pending'
            ]);

            $user->decrement('wallet', $payoutsDetail->getBatchHeader()->getAmount()->getValue());

            $response = $this->formatResponse('success', 'Payment in processing!');
        } else {
            $response = $this->formatResponse('error_payout', 'Error Payout!');
        }

        return response($response, 200);
    }

}