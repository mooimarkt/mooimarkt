<?php

namespace App;

use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use PayPal\Api\Agreement;
use PayPal\Api\Payer;
use PayPal\Api\ShippingAddress;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;
use PayPal\Api\AgreementStateDescriptor;

use App\Option;
use App\PayPalPlan;

use Illuminate\Database\Eloquent\Model;

class PayPalAgreements extends Model{

	public $table = "paypal_agreements";
	public $guarded = [];

	public function User(){

		return $this->hasOne("App\User",'id','uid');

	}

}