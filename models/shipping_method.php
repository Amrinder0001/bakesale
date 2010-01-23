<?php

/**
 * shipping_method.php
 *
 * @author Matti Putkonen,  matti.putkonen@fi3.fi
 * @copyright Copyright (c); 2006-2009, Matti Putkonen, Helsinki, Finland
 * @package BakeSale
 * @version $Id: shipping_method.php 246 2006-12-24 13:55:42Z matti $
 */

class ShippingMethod extends AppModel
{

	public $hasMany = array('ShippingRule' =>
                       array('className' => 'ShippingRule',
        	         'dependent' => true));
	public $hasAndBelongsToMany = array('Country'  =>
                       array('className' => 'Country'));
	public $types = array('weight','price', 'products');

	public $validate = array(
    'name' => array(
    	'notEmpty' => array(
        'rule' => 'notEmpty',  
        'message' => 'Name is required',
        'required' => true,
        'on' => 'edit',
    	),  
    ),
	);

/**
 * get price for shipping
 * @param $id int ShippingMethod id
 */

    public function getQuote($id = false, $cart) {
	    if(!$id) {
        $id = Configure::read('Order.shipping_method_id');
    }
    $data = $this->findById($id);
    $shipping_cost = $data['ShippingMethod']['price'];

    if (!empty($data['ShippingRule'])) {
    	$total['price'] = $cart['Order']['subtotal'];
    	$total['weight'] = $cart['Order']['weight'];
    	$total['quantity'] = $cart['Order']['quantity'];

    	foreach ($data['ShippingRule'] as $rule) {
        foreach ($this->types as $type) {
        	if (($rule['type'] == $type) && ($total[$type] > $rule['min']) && ($total[$type] < $rule['max'])) {
            $shipping_cost += $rule['price'];
        	}
        }
    	}
    }
    return $shipping_cost;
	}

/**
 * get price for multiple shipping methods
 * @param $id int ShippingMethod id
 */

    public function getAllQuotes($data, $cart) {
    foreach ($data as $key => $row) {
    	$data[$key]['price'] = $this->getQuote($row['id'], $cart);
    }
    return $data;
	}

/**
* get default shipping method id for the country
* KALILEO: Moved from controller to Model
*/

    public function getDefaultId($country_id) {
        $data = $this->find('first', 
    array('conditions' => array('active' => '1'/*, 'Country.id' => $country_id*/), 'order' => 'sort ASC', 'recursive' => -1));
        return($data[0]['ShippingMethod']['id']);
    }

/**
* get default shipping method id for the country
* KALILEO: Moved from controller to Model
*/

    public function cartShippingMethodId() {
        return Configure::read('Order.shipping_method_id');
    }

/**
* Get the name of the payment method registered for shopping cart
* @return the name of the payment method.
*/

    public function getShoppingCartShippingMethodName() {
        $data = $this->find('first', array('conditions' => array('id' => $this->cartShippingMethodId())), -1);
        return $data['ShippingMethod']['name'];
    }

 
/**
* get shipping types
*/

    public function types() {
        return $this->types;
    }

/**
 * Add new shipping method
 */

    public function _rule_types() {
    $data2 = array();
    foreach($this->types as $key => $row) {
    	$data_temp = array($row => $row);
    	$data2 = array_merge($data2, $data_temp);
    }
    return $data2;
    }

}
?>