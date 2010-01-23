<?php
class PaypalController extends PaymentAppController
{

/**
 * Data unique to shop
 */
	public $defaults = array(
    'business' => 'seller_1214391092_biz@fi3.fi',
    'mode' => 'test',
    );
 
 /**
 * show form page
 */

	public function index() {
    $payment = $this->get_info();

    $data['shipping_1'] = $payment['Order']['shipping_handling'];
    $data['cmd'] = '_cart';
    $data['business'] =  Configure::read('paypal.business');
    $data['upload'] =  '1';
    $data['custom'] =  $payment['Order']['id'];
    $data['currency_code'] = $this->get_currency(array('AUD', 'CAD', 'EUR', 'GBP', 'HKD', 'JPY', 'USD'));
    $data['return'] = $payment['Store']['success_url'];
    $data['cancel_return'] = $payment['Store']['cancel_url'];
    $data['notify_url'] = FULL_BASE_URL . Router::url('/') . 'payment/paypal/ipn/';
    
    if(Configure::read('paypal.mode') == 'test') {
    	$data['form_action'] = 'https://www.sandbox.paypal.com/cgi-bin/webscr';    
    } else {
    	$data['form_action'] = 'https://secure.paypal.com/cgi-bin/webscr';
    }
    $mode = Configure::read('paypal.mode');
    $data = array_merge($data, $this->_products($payment['Order']['products_array']));
    $this->set(compact('data'));
	}

/**
 * @protected
 */
 
	public function _products($data) {
    foreach ($data as $row) {
    	$products['item_name_' . $row['counter']] = $row['name'];
    	$products['quantity_' . $row['counter']] = $row['quantity'];
    	$products['amount_' . $row['counter']] = number_format($row['price'], 2, '.', '');
    }
    return $products;
	}

/**
 * IPN
 */

	public function ipn() {
    if($_SERVER['REQUEST_METHOD']!="POST") {
    	//die("No data");
    }
    $this->log('ipn');
    $url = $this->_ipnUrl($_POST);
    $req = $this->_ipnTransaction($_POST);
    $result = $this->_ipnPostBack($req, $url);

    if (strpos($result, "VERIFIED")!==false) {
    	$this->_verifyOrder($_POST['custom']);
    }
	}

/**
 * Get paypal url
 */

    public function _ipnUrl($postArray){
    if(!isset($postArray['test_ipn'])){
    	$url = 'https://www.paypal.com/cgi-bin/webscr';
    } else { 
    	$url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    }
    $this->log('__ipnUrl');
    $this->log($url);
    return $url;
    }

/**
 * we have to add 'cmd' 'notify-validate' to a transaction variable
 * and add everything paypal has sent to the transaction
 */

    public function _ipnTransaction($postArray){
    $transaction = 'cmd=_notify-validate';
    foreach ($postArray as $key => $value) {
    	$value = urlencode(stripslashes($value));
    	$transaction .= "&$key=$value";
    }
    $this->log('__ipnTransaction');
    return $transaction;
    }

/**
 * post back to PayPal system to validate
 */

    public function _ipnPostBack($req, $url){
    	$curl_result=$curl_err='';
    $ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL,$url);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    	curl_setopt($ch, CURLOPT_POST, 1);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
    	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded", "Content-Length: " . strlen($req)));
    curl_setopt($ch, CURLOPT_HEADER , 0);   
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $response = @curl_exec($ch);
    $curl_err = curl_error($ch);
    curl_close($ch);
    $this->log($response);
    $this->log($curl_err);
    $this->log('__ipnPostBack');
    return $response;
    }

/**
 * 
 */

    public function _verifyOrder($id){
    $this->log('__verifyOrder');
    $order = ClassRegistry::init('Order'); 
    $order->id = $id;
    $order->saveField('verified', 1);
	}

}
?>