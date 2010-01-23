<?php

/**
 * psigate_controller.php
 *
 * @author Matti Putkonen,  matti.putkonen@fi3.fi
 * @copyright Copyright (c); 2006, Matti Putkonen, Helsinki, Finland
 * @package BakePay
 * @version $Id: psigate_controller.php 461 2007-06-28 08:03:44Z matti $
 */

class PsigateController extends PaymentAppController
{

/**
 * Data unique to shop
 */

	public $defaults = array(
    'store_id' => 'teststore',
    'pass_phrase' => 'psigate1234',
    'method' => 'form',
    'result' => '1',
    'charge_type' => '0',
    );

/**
 * Fields collected from client
 */

	public $fields = array(
    'card_number',
    'month',
    'year',
    );

/**
 * Generate data fields to send to gateway
 *
 * @param $data
 * @protected
 */
 
	public function _generate() {
	    $payment = $this->get_info();

    $data['StoreID'] = Configure::read('psigate.store_id');
    $data['Passphrase'] = Configure::read('psigate.pass_phrase');
    $data['Subtotal'] = $payment['Order']['total'];
    $data['PaymentType'] = 'CC';
    $data['CardAction'] = '0';
    
    return $data;
	}	

/**
 * Generate data fields to send to gateway
 *
 * @protected
 */
 
	public function _generate_form() {
	    $payment = $this->get_info();

    $data['MerchantID'] = Configure::read('psigate.store_id');
    $data['FullTotal'] = $payment['Order']['total'];
    $data['ThanksURL'] = $payment['Store']['success_url'];
    $data['NoThanksURL'] = $payment['Store']['cancel_url'];
    $data['Bname'] = $payment['Customer']['name'];
    $data['Baddr1'] = $payment['Customer']['address'];
    $data['Bcity'] = $payment['Customer']['city'];
    $data['Bstate'] = $payment['Customer']['state'];
    $data['Bzip'] = $payment['Customer']['postcode'];
    $data['Bcountry'] = $payment['Customer']['Country']['name'];
    $data['Phone'] = $payment['Customer']['phone'];
    $data['Email'] = $payment['Customer']['email'];
    $data['Sname'] = $payment['Customer']['s_name'];
    $data['Saddr1'] = $payment['Customer']['s_address'];
    $data['Scity'] = $payment['Customer']['s_city'];
    $data['Sstate'] = $payment['Customer']['s_state'];
    $data['Szip'] = $payment['Customer']['s_postcode'];
    $data['Scountry'] = $payment['Customer']['ShippingCountry']['name'];
    $data['ChargeType'] = Configure::read('psigate.charge_type');
    $data['Result'] = Configure::read('psigate.result');
    $data['IP'] = $payment['Customer']['ip'];
    return $data;
	}	


/**
 * show form page
 */
	
	public function index() {
    if(Configure::read('psigate.method') == 'form') {
    	$data = $this->_generate_form();
    	$data['form_action'] = 'https://order.psigate.com/psigate.asp';
    	$this->set(compact('data'));
    } else {
	    	$this->redirect(array('action' => 'card'));
    }
	}

/*
 * show form page
 */
 
	public function card() {
    $this->set('fields', $this->fields);
    if(isset($this->data['Payment'])) {
    	$data['CardNumber'] = $this->data['Payment']['card_number'];
    	$data['CardExpMonth'] = $this->data['Payment']['month'];
    	$data['CardExpYear'] = $this->data['Payment']['year'];

    	$data = array_merge($this->_generate(), $data);
    	$this->_connect($data);
    }
	}


/**
 * send to to gateway
 *
 * @param $data
 * @protected
 */
 
	public function _connect($data) {
    $data = $this->_format_data($data);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://dev.psigate.com:7989/Messenger/XMLMessenger');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_TIMEOUT, 120);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $buffer = curl_exec($ch);
    curl_close($ch);
    $this->_verify($buffer);
	}

/**
 * Format data sent to gateway
 *
 * @param $data
 * @protected
 */
 
	public function _format_data($data) {
    $fields = '<Order>';
    foreach($data as $key => $value) { 
    	$fields .= '<' . $key . '>' . $value . '</' .$key . '>';
    }
    $fields .= '</Order>';
    
    return $fields;
	}

/**
 * Verify transaction
 *
 * @param $data
 * @protected
 */

	public function _verify($data) {
    if(strstr($data, '<Approved>APPROVED</Approved>')) {
    	$this->redirect('/orders/success/');
    } else  {
    	$error = $this->error_message($data);
    	$this->Session->setFlash($error);
    	$this->redirect('/payment/psigate/');
    }
	}

/**
 * Get error from gateway response
 */
	
	public function error_message($data) {
    if(strstr($data, '<Approved>DECLINED</Approved>')) {
    	$error = 'Error';
    } else {
    	$error = 'Credit Card Declined';
    }
    return $error;
	}

}
?>