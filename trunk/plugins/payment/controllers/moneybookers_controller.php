<?php

/**
 * moneybookers_controller.php
 *
 * @author Matti Putkonen,  matti.putkonen@fi3.fi
 * @copyright Copyright (c); 2006, Matti Putkonen, Helsinki, Finland
 * @package BakePay
 * @version $Id: moneybookers_controller.php 461 2007-06-28 08:03:44Z matti $
 */

class MoneybookersController extends PaymentAppController
{

/**
 * Data unique to shop
 */

	public $defaults = array(
    'email' => 'matti.putkonen@fi3.fi',
    );

/**
 * Generate data fields to send to gateway
 *
 */

	public function index() {
	    
	    $payment = $this->get_info();

    $data = array(
        	'amount' => $payment['Order']['total'],	
    	'pay_to_email' => Configure::read('moneybookers.email'),
    	'language' => $this->get_language(array ('EN', 'DE', 'ES', 'FR', 'IT', 'PL')),
    	'currency' => $this->get_currency(array ('AUD', 'GBP', 'BGN', 'CAD', 'CZK', 'DKK', 'EEK', 'EUR', 'HKD', 'HUF', 'ISK', 'INR', 'ILS', 'JPY', 'LVL', 'MYR', 'NZD', 'NOK', 'PLN', 'ROL', 'SGD', 'SKK', 'SIT', 'ZAR', 'KRW', 'SEK', 'CHF', 'TWD', 'THB', 'USD')),
    	'detail1_description' => __('Products', true),
    	'detail1_text' => $payment['Order']['products'],
    	'firstname' => $payment['Customer']['firstname'],
    	'lastname' => $payment['Customer']['lastname'],
    	'address' => $payment['Customer']['address'],
    	'phone' => $payment['Customer']['phone'],
    	'city' => $payment['Customer']['city'],
    	'postal_code' => $payment['Customer']['postcode'],
    	'pay_from_email' => $payment['Customer']['email'],
    	'return_url' => $payment['Store']['success_url'],
    	'cancel_url' => $payment['Store']['cancel_url'],
    	'form_action' => 'https://www.moneybookers.com/app/payment.pl',
    );

    $this->set(compact('data'));
	}

}
?>