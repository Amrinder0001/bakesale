<?php

/**
 * chronopay_controller.php
 *
 * @author Matti Putkonen,  matti.putkonen@fi3.fi
 * @copyright Copyright (c); 2006, Matti Putkonen, Helsinki, Finland
 * @package BakePay
 * @version $Id: chronopay_controller.php 462 2007-07-03 08:32:26Z matti $
 */

class ChronopayController extends PaymentAppController
{

/**
 * Data unique to shop
 */

	public $defaults = array(
		'product_id' => '001025-0001-0005',
		'sign' => ''
		);

/**
 * show form page
 */

	public function index() {
	    $payment = $this->get_info();
		$data = array(
			'product_price' => $payment['Order']['total'],
			'product_id' => Configure::read('chronopay.product_id'),
			'product_name' => $payment['Order']['products'],
			'cs1' => '54',
			'f_name' => $payment['Customer']['firstname'],
			's_name' => $payment['Customer']['lastname'],
			'phone' => $payment['Customer']['phone'],
			'email' => $payment['Customer']['email'],
			'street' => $payment['Customer']['address'],
			'city' => $payment['Customer']['city'],
			'zip' => $payment['Customer']['postcode'],
			'country' => $payment['Customer']['Country']['code3'],
			'x_state' => $payment['Customer']['state'],
			'language' => $this->get_language(array('RU', 'NL', 'ES', 'EN')),
			'cb_url' => $payment['Store']['success_url'];
			'decline_url' => $payment['Store']['cancel_url'];
			'form_action' => 'https://secure.chronopay.com/index_shop.cgi'
		);
		$this->set(compact('data'));
	}

}
?>