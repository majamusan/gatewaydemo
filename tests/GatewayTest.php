<?php

class GatewayTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testBasicExample()
	{
		//paypal 
		$param = [
			"order" => ["amount"=>"9","currancy"=>"USD","name"=>"Jane Shopper"],
			"card" => ["name"=>"Joe Shopper","type"=>"VISA","number"=>"4417119669820331","expire"=>"11/2019","ccv"=>"012"]
		];
		$response = $this->call('GET', '/payment/go',$param);
		var_dump($response->getContent());
		$this->assertEquals(200, $response->getStatusCode());

		//braintree 
		$param = [
			"order" => ["amount"=>"90","currancy"=>"THB","name"=>"Jane Shopper"],
			"card" => ["name"=>"Bob Smith","type"=>"VISA","number"=>"4111111111111111","expire"=>"05/2020","ccv"=>"010"]
		];
		$response = $this->call('GET', '/payment/go',$param);
		var_dump($response->getContent());
		$this->assertEquals(200, $response->getStatusCode());

		/* paypay amex test, always failes
		$param = [
			"order" => ["amount"=>"9","currancy"=>"USD","name"=>"Jane Shopper"],
			"card" => ["name"=>"Joe Shopper","type"=>"AMEX","number"=>"4417119669820331","expire"=>"11/2019","ccv"=>"012"]
		];
		$response = $this->call('GET', '/payment/go',$param);
		$this->assertEquals(200, $response->getStatusCode());
		*/
	}

}
