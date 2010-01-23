<?php

/**
 * mobillcash_controller.php
 *
 * @author Matti Putkonen,  matti.putkonen@fi3.fi
 * @copyright Copyright (c); 2006, Matti Putkonen, Helsinki, Finland
 * @package BakePay
 * @version $Id: mobillcash_controller.php 461 2007-06-28 08:03:44Z matti $
 */


class MobillcashController extends PaymentAppController
{

/**
 * Data unique to shop
 */

	public $defaults = array(
    'account' => '',
    );

/**
 * show form page
 */

	public function index() {
	    $payment = $this->get_info();
    $data = array(
    	'account' => Configure::read('mobillcash.account'),
    	'amount' => $payment['Order']['total'],
    	'reference' => $payment['Order']['id'],
    	'currency' =>   $this->get_currency(array ('GBP', 'EUR', 'SEK', 'NOK', 'DKK', 'USD')),
    	'redirect' => $payment['Store']['success_url'],
    	'form_action' => 'https://www.mobillcash.com/pay/',
    	'form_method' => 'get'
    );
    $this->set(compact('data'));
	}

}
?>