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


class PayPalPlan {

	private $_plan = null;
	private $_apiContext = null;

	function __construct( \PayPal\Rest\ApiContext $apiContext, $plan_details=[] ) {

		$plan = new Plan();

		$plan->setName( key_exists( 'name', $plan_details ) ? $plan_details['name'] : 'Trader Subscription' )//'Trader Subscription'
		     ->setDescription( key_exists( 'description', $plan_details ) ? $plan_details['description'] : 'Trader Subscription Description' )//'Trader Subscription 1'
		     ->setType( 'fixed' );

		$paymentDefinition = new PaymentDefinition();

		$Currency = new Currency(
			array(
				'value'    => key_exists( 'amount', $plan_details ) ? $plan_details['amount'] : 10,
				'currency' => key_exists( 'currency', $plan_details ) ? $plan_details['currency'] : 'USD'
			) );

		$paymentDefinition->setName( key_exists( 'subscription', $plan_details ) ? $plan_details['subscription'] : 'Subscription' )
		                  ->setType( 'REGULAR' )
		                  ->setFrequency( key_exists( 'frequency', $plan_details ) ? $plan_details['frequency'] : 'Month' )
		                  ->setFrequencyInterval( key_exists( 'interval', $plan_details ) ? $plan_details['interval'] : "1" )
		                  ->setCycles( key_exists( 'cycles', $plan_details ) ? $plan_details['cycles'] : "12" )
		                  ->setAmount( $Currency );

		$chargeModel = new ChargeModel();
		$chargeModel->setType( 'SHIPPING' )
		            ->setAmount( $Currency );

		$paymentDefinition->setChargeModels( array( $chargeModel ) );
		$merchantPreferences = new MerchantPreferences();
		$baseUrl             = url( "/" );

		$merchantPreferences->setReturnUrl( key_exists( 'redirect_url', $plan_details ) ? $plan_details['redirect_url'] : "$baseUrl/paypal/back?success=true" )
		                    ->setCancelUrl( key_exists( 'cancel_url', $plan_details ) ? $plan_details['cancel_url'] : "$baseUrl/paypal/back?success=false" )
		                    ->setAutoBillAmount( "yes" )
		                    ->setInitialFailAmountAction( "CONTINUE" )
		                    ->setMaxFailAttempts( key_exists( 'max_fail', $plan_details ) ? $plan_details['max_fail'] : "2" )
		                    ->setSetupFee( new Currency( array(
				                    'value'    => key_exists( 'setup_fee', $plan_details ) ? $plan_details['setup_fee'] : 1,
				                    'currency' => key_exists( 'currency', $plan_details ) ? $plan_details['currency'] : 'USD'
			                    )
		                    ) );

		$plan->setPaymentDefinitions( array( $paymentDefinition ) );
		$plan->setMerchantPreferences( $merchantPreferences );

		$this->_plan       = $plan->create( $apiContext );
		$this->_apiContext = $apiContext;

	}

	public function Update($data) {

		try {
			$patch = new Patch();
			$value = new PayPalModel( json_encode($data) );

			$patch->setOp( 'replace' )
			      ->setPath( '/' )
			      ->setValue( $value );

			$patchRequest = new PatchRequest();
			$patchRequest->addPatch( $patch );
			$this->_plan->update( $patchRequest, $this->_apiContext );

			$this->_plan = Plan::get( $this->_plan->getId(), $this->_apiContext );

		} catch ( \Exception $ex ) {

			return [
				'error'   => $ex->getMessage(),
				'request' => $patchRequest,
			];

		}

		return true;

	}

	public function ActivatePlan() {

		return $this->Update([
			"state"=>"ACTIVE"
		]);

	}



	public function CreateAgreement($data=[]){

		$agreement = new Agreement();

		$agreement->setName(key_exists( 'name', $data ) ? $data['name'] : 'Base Agreement')
		          ->setDescription(key_exists( 'description', $data ) ? $data['description'] : 'Basic Agreement')
		          ->setStartDate(key_exists( 'startDate', $data ) ? $data['startDate'] : '2019-06-17T9:45:04Z');

		$plan = new Plan();
		$plan->setId($this->_plan->getId());
		$agreement->setPlan($plan);

		$payer = new Payer();
		$payer->setPaymentMethod('paypal');
		$agreement->setPayer($payer);

		return $agreement->create($this->_apiContext);

	}

}