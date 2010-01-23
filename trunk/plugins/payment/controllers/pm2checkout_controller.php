<?php

/**
 * pm2checkout_controller.php
 *
 * @author Matti Putkonen,  matti.putkonen@fi3.fi
 * @copyright Copyright (c); 2006, Matti Putkonen, Helsinki, Finland
 * @package BakePay
 * @version $Id: pm2checkout_controller.php 461 2007-06-28 08:03:44Z matti $
 */

class Pm2checkoutController extends PaymentAppController
{

/**
 * Data unique to shop
 */

	public $defaults = array(
    'x_login' => '123',
    'demo' => 'Y',
    );

/**
 * Generate data fields to send to gateway
 *
 */

	public function index() {
	    $payment = $this->get_info();
    $data = array(
    	'x_amount' => $payment['Order']['total'],
    	'sh_cost' => $payment['Order']['shipping_handling'],
    
    	'x_login' => Configure::read('pm2checkout.x_login'),
    	'x_invoice_num' => $payment['Order']['id'],
    	'x_first_name' => $payment['Customer']['firstname'],
    	'x_last_name' => $payment['Customer']['lastname'],
    	'x_address' => $payment['Customer']['address'],
    	'x_city' => $payment['Customer']['city'],
    	'x_zip' => $payment['Customer']['postcode'],
    	'x_country' => $payment['Customer']['Country']['name'],
    	'x_email' => $payment['Customer']['email'],
    	'x_phone' => $payment['Customer']['phone'],
    	'x_ship_to_first_name' => $payment['Customer']['s_firstname'],
    	'x_ship_to_last_name' => $payment['Customer']['s_lastname'],
    	'x_ship_to_address' => $payment['Customer']['s_address'],
    	'x_ship_to_state' => $payment['Customer']['s_state'],
    	'x_state' => $payment['Customer']['s_state'],
    	'x_ship_to_city' => $payment['Customer']['s_city'],
    	'x_ship_to_zip' => $payment['Customer']['s_postcode'],
    	'x_ship_to_country' => $payment['Customer']['ShippingCountry']['name'],
    	'x_email_merchant' => 'TRUE',
    	'fixed' => 'Y', 
    	'x_receipt_link_url' => $payment['Store']['cancel_url'],
    	'tco_currency' => $this->get_currency(array('AUD', 'CAD', 'CHF', 'DKK', 'EUR', 'GBP', 'HKD', 'JPY', 'NOK', 'NZD', 'SEK', 'USD')),
    	'demo' => Configure::read('pm2checkout.demo'),
    	'id_type' => '',
    	'form_action' => 'https://www2.2checkout.com/2co/buyer/purchase'
    );
    $this->set(compact('data'));
	}

}
?>