<?php

/**
 * eway_controller.php
 *
 * @author Matti Putkonen,  matti.putkonen@fi3.fi
 * @copyright Copyright (c); 2006, Matti Putkonen, Helsinki, Finland
 * @package BakePay
 * @version $Id: eway_controller.php 461 2007-06-28 08:03:44Z matti $
 */

class EwayController extends PaymentAppController
{

/**
 * Data unique to shop
 */
	public $defaults = array(
		'customer_id' => '87654321',
		'method' => 'form',
		);

/**
 * Fields collected from client
 */

	public $fields = array(
		);


/**
 * Generate data fields to send to gateway
 *
 * @protected
 */

	public function _generate($data = false) {
	    $payment = $this->get_info();

		$data['ewayCustomerFirstName'] = $payment['Customer']['firstname'];
		$data['ewayCustomerLastName'] = $payment['Customer']['lastname'];
		$data['ewayCustomerEmail'] = $payment['Customer']['email'];
		$data['ewayCustomerAddress'] = $payment['Customer']['address'];
		$data['ewayCustomerPostcode'] = $payment['Customer']['postcode'];
		$data['ewayCustomerInvoiceDescription'] = __('Order', true);
		$data['ewayCustomerInvoiceRef'] = $payment['Order']['id'];
		$data['ewayCustomerID'] = Configure::read('eway.customer_id');
		$data['ewayTrxnNumber'] = '4230';
        $data['ewayTotalAmount'] = $payment['Order']['raw_total'];	
		if(Configure::read('eway.method') == 'form') {
			$data['eWAYURL'] = $payment['Store']['success_url'];
			$data['eWAYAutoRedirect'] = '1';
			$data['eWAYSiteTitle'] = $payment['Store']['name'];
		} 
		return $data;
	}

/**
 * show form page
 */
 
	public function index() {
		if(Configure::read('eway.method') == 'form') {
			$data = $this->_generate();
			$data['form_action'] = 'https://www.eway.com.au/gateway/payment.asp';
			$this->set(compact('data'));
		} else {
	        $this->redirect(array('action' => 'card'));
		}
	}

/**
 * show card page
 */
 
	public function card() {
		$this->set('fields', $this->fields);
		if(isset($this->data)) {
			$data['ewayCardNumber'] = $this->data['Payment']['card_number'];
			$data['ewayCardExpiryMonth'] = $this->data['Payment']['month'];
			$data['ewayCardExpiryYear'] = $this->data['Payment']['year'];
			$data['ewayCardHoldersName'] = $this->data['Payment']['name'];
			
			$data = array_merge($this->_generate(), $data);
			$this->_connect($data);
		}
		
	}


/**
 * send data to gateway
 *
 * @protected
 */
 
	public function _connect($data) {
		$data = $this->_format_data($data, 'ewaygateway');

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://www.eway.com.au/gateway/xmltest/testpage.asp');
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_TIMEOUT, 240);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$buffer = curl_exec($ch);
		curl_close($ch);
		$this->_verify($buffer);
	}

/**
 * Format data sent to gateway
 *
 * @protected
 */

	public function _format_data($data, $base) {
		$fields = '<' . $base . '>';
		foreach($data as $key => $value) { 
			$fields .= '<' . $key . '>' . htmlentities($value) . '</' .$key . '>';
		}
		$fields .= '</' . $base . '>';
		
		return $fields;
	}

/**
 * Verify transaction
 *
 * @protected
 */

	public function _verify($data) {
		if(!strstr($data, '<ewayTrxnStatus>False</ewayTrxnStatus>')) {
			$this->Session->setFlash($data);
		} else {
			$this->redirect('/orders/success/');
		}
	}

}
?>