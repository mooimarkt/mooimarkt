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

class PayPal {

	private $_env = null;

	public function Env() {

		if(!is_null($this->_env)){
			return $this->_env;
		}

		try{

			$this->_env = new \PayPal\Rest\ApiContext(
				new \PayPal\Auth\OAuthTokenCredential(
					Option::getSetting("opt_paypal_acc_id"),
					Option::getSetting("opt_paypal_acc_secret")
				)
			);

			$this->_env->setConfig([
				'mode' => 'sandbox'
			]);

			return $this->_env;

		}catch (\Exception $e){

			return $e->getMessage();

		}

	}

	public function CreateAgreement($data=[]){

		try{

			$Plan = new PayPalPlan($this->Env(),key_exists('plan',$data) ? $data['plan'] : []);

			$res = $Plan->ActivatePlan();

			if(is_array($res) && key_exists('error',$res)){

				throw new Exception($res['error']);

			}

			return $Plan->CreateAgreement(key_exists('agreement',$data) ? $data['agreement'] : []);

		}catch (\Exception $e){

			return $e->getMessage();

		}

	}

	public function ExecuteAgreemen($token){

		$agreement = new \PayPal\Api\Agreement();

		try {

			$apiContext = $this->Env();

			$agreement->execute($token,$apiContext );

			return \PayPal\Api\Agreement::get($agreement->getId(), $apiContext);

		} catch (\Exception $ex) {

			return [
				'error'  => $ex->getMessage(),
				'token' => $token,
			];

		}

	}

	public function SuspendAgreement($id=0,$note="Suspending the agreement"){

		try {

			$agreementStateDescriptor = new AgreementStateDescriptor();
			$agreementStateDescriptor->setNote($note);

			Agreement::get($id, $this->Env())->suspend($agreementStateDescriptor, $this->Env());

		} catch (\Exception $ex) {

			return [
				'error'  => $ex->getMessage(),
				'token' => $agreementStateDescriptor,
			];

		}

		return true;


	}

	public function ReactivateAgreement($id=0,$note="Reactivating the agreement"){

		$agreementStateDescriptor = new AgreementStateDescriptor();
		$agreementStateDescriptor->setNote("Reactivating the agreement");

		try {

			Agreement::get($id, $this->Env())->reActivate($agreementStateDescriptor, $this->Env());

		} catch (\Exception $ex) {

			return [
				'error'  => $ex->getMessage(),
				'token' => $agreementStateDescriptor,
			];

		}

		return true;

	}

}