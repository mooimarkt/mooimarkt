<?php

namespace App\Http\Requests;

use LVR\CreditCard\CardCvc;
use LVR\CreditCard\CardNumber;
use LVR\CreditCard\CardExpirationYear;
use LVR\CreditCard\CardExpirationMonth;

class CreditCardPaymentRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'amount' => 'required|integer|min:1',
            'card_name' => 'required',
            'card_number' => ['required', new CardNumber],
            'card_month' => ['required', new CardExpirationMonth($this->card_year ?? 0)],
            'card_year' => ['required', new CardExpirationYear($this->card_month ?? 0)],
            'card_cvv' => ['required', new CardCvc($this->card_number)]
        ];
    }
}