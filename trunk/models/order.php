<?php

/**
 * order.php
 *
 * @author Matti Putkonen,  matti.putkonen@fi3.fi
 * @copyright Copyright (c); 2006-2009, Matti Putkonen, Helsinki, Finland
 * @package BakeSale
 * @version $Id: order.php 514 2007-10-14 07:09:38Z matti $
 */

class Order extends AppModel
{

	public $hasMany = array('LineItem' =>
                   		array('className'    => 'LineItem',
					   		  'dependent'    =>  true));
	public $virtualFields = array(
		'name' => "CONCAT(Order.firstname, ' ', Order.lastname)",
		's_name' => "CONCAT(Order.s_firstname, ' ', Order.s_lastname)"
	);

	public $validate = array(
		'firstname' => array(
			'notEmpty' => array(
		        'required' => true,
				'on' => 'update',
				'rule' => 'notEmpty',  
				'message' => 'Firstname is required'
			),  
		),
		'lastname' => array(
			'notEmpty' => array(
		        'required' => true,
				'on' => 'update',
				'rule' => 'notEmpty',  
				'message' => 'Lastname is required'
			),  
		),
		'address' => array(
			'notEmpty' => array(
		        'required' => true,
				'on' => 'update',
				'rule' => 'notEmpty',  
				'message' => 'Address is required'
			),  
		),
		'postcode' => array(
			'notEmpty' => array(
		        'required' => true,
				'on' => 'update',
				'rule' => 'notEmpty',  
				'message' => 'Postcode is required'
			),  
		),
		'phone' => array(
			'notEmpty' => array(
		        'required' => true,
				'on' => 'update',
				'rule' => 'notEmpty',  
				'message' => 'Phonenumber is required'
			),  
		),
		'email' => array(
			'notEmpty' => array(
		        'required' => true,
				'on' => 'update',
				'rule' => 'notEmpty',  
				'message' => 'Email is required'
			),  
		),
	);

/**
 *
 */
/*
	public function afterFind($result){
		if(!empty($result[0]['Order']['id'])){
			foreach ($result as $key => $row) {
				if(empty($result[$key]['Order']['name'])) {
					if(!empty($result[$key]['Order']['firstname'])) {
						$result[$key]['Order']['name'] = $result[$key]['Order']['firstname'] . ' ' . $result[$key]['Order']['lastname']; 
						$result[$key]['Order']['s_name'] = $result[$key]['Order']['s_firstname'] . ' ' . $result[$key]['Order']['s_lastname']; 
					}
				}
			}
		}
		return $result;
	}
*/
/**
 * Strip tags to prevent XSS attacks
 */

	public function beforeSave() {
		foreach ($this->data['Order'] as $key => $row) {
			//$this->data['Order'][$key] = strip_tags($row);
		}
		return true;
	}

/**
 * Get shopping cart session
 */

	public function getCartSession() {
		return Configure::read('Order.session');
	}

/**
 * get cart id by session. if no existing cart, make a new one
 */

	public function getCartId() {
		$data = $this->findBySession($this->getCartSession());
		if($data) {
			return $data['Order']['id'];
		} 
		return $this->setCartId();
	}

/**
 * Make a new order
 */

	public function setCartId() {
		$this->data['Order']['session'] = $this->getCartSession();
		$this->save($this->data, array('validate' => false));
		return $this->getLastInsertID();
	}

/**
 * Get full cart contents by session
 */

	public function fullBySession($countTotal = false) {
		$session = $this->getCartSession();
		$base = $this->find('first', array('conditions' => array('session' => $session), 'recursive' => 3));
		$data = $this->totals($base);
		if($countTotal) {
			$data = $this->countTotal($data);
		}
		return $data;
	}

/**
 * Add totals to order and line items
 */

	public function totals($data){
		if(!empty($data['Order'])) {
			$data['Order']['subtotal'] = '';
			$data['Order']['weight'] = '';
		}		
		if(!empty($data['LineItem'])) {
			$data = $this->stock($data);
			$data = $this->price($data);
			$data = $this->weight($data);
		}
		$data['Order']['shipping_price'] = ClassRegistry::init('ShippingMethod')->getQuote(false, $data);
		$data['Order']['payment_price'] = ClassRegistry::init('PaymentMethod')->getQuote();
		return $data;
	}


/**
 * Count quantity for line items
 */

	public function stock($data){
		$data['Order']['quantity'] = '';
		foreach($data['LineItem'] as $key => $row) {
			$out_of_stock = false;
			if (!empty($row['Subproduct'])) { 
				$quantity = $row['Subproduct']['quantity'];
	        } else {
				$quantity = $row['Product']['quantity'];
	        }
			 if ($row['quantity'] > $quantity) {
				$out_of_stock = true;
				$data['Order']['error'] = 'quantity';
			}
			$data['LineItem'][$key]['out_of_stock'] = $out_of_stock;
			$data['LineItem'][$key]['quantity_available'] = $quantity;
			$data['Order']['quantity'] += $row['quantity'];
		}
		return $data;
	}

/**
 * Count price for line items
 */

	public function price($data){
		foreach($data['LineItem'] as $key => $row) {
			if ($row['Product']['special_price'] > 0) { 
				$price = $row['Product']['special_price'];
	        } else {
				$price = $row['Product']['price'];
	        }
			if (!empty($row['Subproduct'])) {
				if($row['Subproduct']['price'] > 0) {
					$price = $row['Subproduct']['price'];
				}
	        }
			$data['LineItem'][$key]['price'] = $price;
			$data['LineItem'][$key]['subtotal'] = $row['quantity'] * $price;
			$data['Order']['subtotal'] += $row['quantity'] * $price;
		}
		return $data;
	}

/**
 * Count weight for line items
 */

	public function weight($data){
		foreach($data['LineItem'] as $key => $row) {
			$weight = $row['Product']['weight'];
			if (!empty($row['Subproduct'])) {
				if($row['Subproduct']['weight'] != 0) {
					$weight = $row['Subproduct']['weight'];
				}
	        }
			$data['LineItem'][$key]['weight'] = $weight;
			$data['Order']['weight'] += $row['quantity'] * $weight;
		}
		return $data;
	}

/**
 * After find combine and count results to create pseudo fields
 */

	public function finalized($id){
		$data = $this->read(null, $id);
		return $this->countTotal($data);
	}

/**
 * Finalize order
 */
 
    public function convert($data) {
		
		if(isset($data['payment_method_id'])) {
			$payment = ClassRegistry::init('PaymentMethod')->findById($data['payment_method_id']);
		}
		$order = array(
				'number' => $this->getNextOrderNumber(),
    			'shipping_method' => ClassRegistry::init('ShippingMethod')->getShoppingCartShippingMethodName(),
    			'payment_method' => $payment['PaymentMethod']['name'],
    			'payment_price' => $payment['PaymentMethod']['price'],
    			'shipping_price' => $data['shipping_handling'] - $payment['PaymentMethod']['price'],				
				'country' => ClassRegistry::init('Country')->getShoppingCartCountryName(),
				'created' => date('Y-m-d H:i:s'),
		);
		return array_merge($data, $order);
	}

/**
 * Get next highest order number
 */
 
    public function getNextOrderNumber() {
		$number = $this->find('first', array('order' => 'number DESC'), -1);
		return (int)$number['Order']['number'] + 1;	
	}

/**
 * After find combine and count results to create pseudo fields
 */

	public function countTotal($data){
		if(!empty($data['Order']['id'])){
			$data['Order']['handling'] = $data['Order']['shipping_handling'] = $data['Order']['shipping_price'] + $data['Order']['payment_price'];
			$data['Order']['subtotal'] = ''; 
			
			if(!empty($data['LineItem'])) {
				foreach ($data['LineItem'] as $key2 => $row2) {
					$data['Order']['subtotal'] += $row2['price'] * $row2['quantity'];
					$data['LineItem'][$key2]['total'] = $data['LineItem'][$key2]['price'] * $data['LineItem'][$key2]['quantity'];
					$name = $row2['product'];
					if(!empty($row2['subproduct'])) {
						$name .= ' (' . $row2['subproduct'] . ')';
					}
					$data['LineItem'][$key2]['name'] = $name;
				}
			}
			$data['Order']['total_ex'] = ($data['Order']['subtotal'] - $data['Order']['discount']) + $data['Order']['handling']; 
			$data['Order']['tax'] = $data['Order']['state_tax'] * $data['Order']['total_ex']; 
			$data['Order']['total'] = $data['Order']['total_ex'] + ($data['Order']['state_tax'] * $data['Order']['total_ex']); 
			$data['Order']['name'] = $data['Order']['firstname'] . ' ' . $data['Order']['lastname']; 
			$data['Order']['s_name'] = $data['Order']['s_firstname'] . ' ' . $data['Order']['s_lastname']; 
		}
		return $data;
	}

}
?>