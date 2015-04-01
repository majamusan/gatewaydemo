<?php

class GatewayTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testBasicExample()
	{
		$param = [
			"order" => ["amount"=>"9","currancy"=>"USD","name"=>"Jane Shopper"],
			"card" => ["name"=>"Joe Shopper","type"=>"VISA","number"=>"4417119669820331","expire"=>"11/2019","ccv"=>"012"]
		];
		$response = $this->call('GET', '/payment/go',$param);
		$this->assertEquals(200, $response->getStatusCode());

		$param = [
			"order" => ["amount"=>"90","currancy"=>"THB","name"=>"Jane Shopper"],
			"card" => ["name"=>"Joe Shopper","type"=>"VISA","number"=>"191919191919191","expire"=>"01/2015","ccv"=>"013"]
		];
		$response = $this->call('GET', '/payment/go',$param);
		$this->assertEquals(200, $response->getStatusCode());

		$param = [
			"order" => ["amount"=>"9","currancy"=>"USD","name"=>"Jane Shopper"],
			"card" => ["name"=>"Joe Shopper","type"=>"AMEX","number"=>"191919191919191","expire"=>"01/2015","ccv"=>"013"]
		];
		$response = $this->call('GET', '/payment/go',$param);
		$this->assertEquals(200, $response->getStatusCode());
	}

}
