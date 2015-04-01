<?php namespace App\Http\Controllers;

// been so long since i have used this kind of config file this seemed to be the best way to include it 
class ConfigController extends Controller {
	public static $currencies = array('USD','EUR','THB','HKD','SGD','AUD');
	public static $cardTypes = array('VISA','MASTER','AMEX');

	public static $gateways = [
				'paypal.id' => 'AYSq3RDGsmBLJE-otTkBtM-jBRd1TCQwFf9RGfwddNXWz0uFU9ztymylOhRS',
				'paypal.secret' => 'EGnHDxD_qRPdaLdZz8iCr8N7_MzF-YHPTkjs6NKYQvQSBngp4PTTVWkPZRbL',
				'braintree.id' => 'mrgn44s3hnh65vz2',
				'braintree.public' => '986dxn9jf8wmfqgz',
				'braintree.private' => 'ddcaf900e7d516dbf4bb34feb3f85f46',
			];
	public static $logics = [
		'paypal.proccess' => array('USD','EUR','AUD'),
		'amex.error' => 'failed AMEX is possible to use only for USD'
			];

}
