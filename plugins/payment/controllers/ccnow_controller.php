<?php
class CcnowController extends PaymentAppController
{

/**
 * Data unique to shop
 */

	public $defaults = array(
		'payee_account' => '3936474',
		'login' => 'amylove',
		'account' => '123456789'
	);

/**
 * show form page
 */

	public function index() {
	    $payment = $this->get_info();
		$data = array(
        	'x_login' => Configure::read('ccnow.login'),
			'x_fp_arg_list' =>  'x_login^x_fp_arg_list^x_fp_sequence^x_amount^x_currency_code',
        	'x_version' =>  '1.0',
        	'x_fp_sequence' =>  '1111084438',
			'x_currency_code' =>   $this->get_currency(array ('AUD', 'CAD', 'EUR', 'GBP', 'HKD', 'JPY', 'USD', 'INR', 'CHF', 'SEK', 'NOK', 'DKK', 'NZD', 'HKD', 'ZAR')),
			'x_method' =>   'NONE',
			'x_name' =>   $payment['Customer']['name'],
			'x_address' =>   $payment['Customer']['address'],
			'x_city' =>   $payment['Customer']['city'],
			'x_zip' =>   $payment['Customer']['postcode'],
			'x_state' => $payment['Customer']['state'],
			'x_country' => $payment['Customer']['Country']['code'],
			'x_email' => $payment['Customer']['email'],
			'x_phone' => $payment['Customer']['phone'],
			'x_shipping_amount' => $payment['Order']['shipping_handling'],
        	'x_amount' => $payment['Order']['total'],
        	'x_invoice_num' => $payment['Order']['id'],
			'form_action' => 'https://www.ccnow.com/cgi-local/transact.cgi'

		);
		$data['x_fp_hash'] = md5($data['x_login'] . '^' . $data['x_fp_arg_list'] . '^' . $data['x_fp_sequence'] . '^' . $data['x_amount'] . '^' . $data['x_currency_code'] . '^' . Configure::read('ccnow.account'));
		$data = array_merge($data, $this->_products($payment['Order']['products_array']));
		
		$this->set(compact('data'));				

	}

/**
 * add products to array
 *
 */
	private function _products($data) {
		foreach ($data as $row) {
			$products['x_product_sku_' . $row['counter']] = $row['id'];
			$products['x_product_title_' . $row['counter']] = $row['name'];
			$products['x_product_quantity_' . $row['counter']] = $row['quantity'];
			$products['x_product_unitprice_' . $row['counter']] = number_format($row['price'], 2, '.', '');
			$products['x_product_url_' . $row['counter']] = $row['url'];
		}
		return $products;
	}
}
?>