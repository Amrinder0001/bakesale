<?php

/**
 * asianpay_controller.php
 *
 * @author Matti Putkonen,  matti.putkonen@fi3.fi
 * @copyright Copyright (c); 2006, Matti Putkonen, Helsinki, Finland
 * @package BakePay
 * @version $Id: asianpay_controller.php 461 2007-06-28 08:03:44Z matti $
 */


class VerkkomaksutController extends PaymentAppController
{

/**
 * Data unique to shop
 */

	public $defaults = array(
    'tunnus' => '13466',
    'varmenne' => '6pKF4jkv97zmqBJ3ZL8gUw5DfT2NMQ'
    );

/**
 * show form page
 */

	public function index() {
	    $payment = $this->get_info();
    $data = array(
    	'MERCHANT_ID' =>  Configure::read('verkkomaksut.tunnus'),    	
    	'AMOUNT' => $payment['Order']['total'],
    	'CURRENCY' => 'EUR',
    	'TYPE' => '3',
    	'ORDER_NUMBER' => $payment['Order']['id'],
    	'ORDER_DESCRIPTION' => $payment['message'],
    	'AUTHCODE' => strtoupper(md5(
        Configure::read('verkkomaksut.varmenne') . '&' . 
        Configure::read('verkkomaksut.tunnus') . '&' .
        $payment['Order']['total'] . '&' .
        $payment['Order']['id']
    	)),
    	'RETURN_ADDRESS' => $payment['Store']['success_url'],
    	'CANCEL_ADDRESS' => $payment['Store']['cancel_url'],
    	'form_action' => 'https://ssl.verkkomaksut.fi/payment.svm'
    );
    $this->set(compact('data'));
	}

}
?>