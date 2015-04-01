<?php namespace App\Http\Controllers;

class GatewayController extends Controller {

//----------------------------------------------------------------------------------------------------------------------[controler functions ]
	public function index() {
		return view('master')->with(array('currencies'=>ConfigController::$currencies,'cardTypes'=>ConfigController::$cardTypes));
	}
	public function payment(){

		$validator = \Validator::make( \Input::all(),
			[
			'order.amount' => 'required|numeric|min:1',
			'order.currancy' => 'required|in:'.implode(',',ConfigController::$currencies),
			'order.name' => 'required|min:4',
			'card.name' => 'required|min:4',
			'card.number' => 'required|alpha_num|min:12|max:19',
			'card.type' => 'required|in:'.implode(',',ConfigController::$cardTypes),
			'card.ccv' => 'required|numeric|min:1|max:999',
			]
		);
		if ($validator->fails()) { return '!valid<br />'.implode('<br />',$validator->messages()->all()); }

		if(\Input::get('card.type') == 'AMEX'){
			if(\Input::get('order.currancy') == 'USD'){
				return $this->paypal(\Input::all());
			}else{
				return ConfigController::$logics['amex.error'];
			}
		}
		if(in_array(\Input::get('order.currancy'),ConfigController::$logics['paypal.proccess'])){
			return $this->paypal(\Input::all());
		}
		return $this->braintree(\Input::all());
	}
//----------------------------------------------------------------------------------------------------------------------[Utility functions ]
	private function saveData($gateway){
		if( \DB::table('storage')->insert( ['order' => serialize(\Input::get('order')), 'gateway' => serialize($gateway)])){
			return ' ~ data saved';
		}else{
			return ' ~ error data !saved';
		}
	}
//----------------------------------------------------------------------------------------------------------------------[Gateway functions ]

	private function paypal($data) {
		$names = explode(' ',\Input::get('card.name'));
		$expire = explode('/',\Input::get('card.expire'));
		
		$apiContext = new \PayPal\Rest\ApiContext(
			new \PayPal\Auth\OAuthTokenCredential(ConfigController::$gateways['paypal.id'],ConfigController::$gateways['paypal.secret'])
		);
		$creditCard = new \PayPal\Api\CreditCard();
		$creditCard->setType(strtolower($data['card']['type']))
								->setNumber($data['card']['number'])
								->setExpireMonth($expire[0])
								->setExpireYear($expire[1])
								->setCvv2($data['card']['ccv'])
								->setFirstName(array_shift($names))
								->setLastName(implode(' ',$names));
		try {
			$creditCard->create($apiContext);
			return \Response::make('procced with paypal'.$this->saveData($creditCard),200,array('Content-Type' => 'text/html'));
		}
		catch (\PayPal\Exception\PayPalConnectionException $ex) {
			return \Response::make('failed with paypal'.$this->saveData('failed'),206,array('Content-Type' => 'text/html'));
		}
	}
	private function  braintree($data) {
		\Braintree_Configuration::environment('sandbox');
		\Braintree_Configuration::merchantId(ConfigController::$gateways['braintree.id']);
		\Braintree_Configuration::publicKey(ConfigController::$gateways['braintree.public']);
		\Braintree_Configuration::privateKey(ConfigController::$gateways['braintree.private']);

		$result = \Braintree_Transaction::sale(array(
			'amount' => $data['order']['amount'],
			'creditCard' => array( 'number' => $data['card']['number'], 'expirationDate' => $data['card']['expire'])
		));

		if ($result->success) {
			return \Response::make('procced with braintree'.$this->saveData($result),200,array('Content-Type' => 'text/html'));
		} else if ($result->transaction) {
			return \Response::make('failed with braintree on error'.$this->saveData('failed error'),206,array('Content-Type' => 'text/html'));
		} else {
			return \Response::make('failed with braintree on validate'.$this->saveData('failed validation'),206,array('Content-Type' => 'text/html'));
		}
	}

}
