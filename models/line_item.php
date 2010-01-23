<?php

/**
 * line_item.php
 *
 * @author Matti Putkonen,  matti.putkonen@fi3.fi
 * @copyright Copyright (c); 2006-2009, Matti Putkonen, Helsinki, Finland
 * @package BakeSale
 * @version $Id: shopping_cart_product.php 246 2006-12-24 13:55:42Z matti $
 */

class LineItem extends AppModel
{

	public $belongsTo = array('Order', 'Product', 'Subproduct');

/**
 * add product to cart
 *
 */

	public function addToCart($data) {
		$current_quantity = $this->getQuantity(
			$data['order_id'],
			$data['product_id'],
			$data['subproduct_id']
		);
		$data['quantity'] = $data['quantity'] + $current_quantity;
		
		if($current_quantity > 0) {
			$this->addQuantity(
				$data['order_id'],
				$data['product_id'],
				$data['quantity'],
				$data['subproduct_id']
			);
		} else {
			$this->data['LineItem'] = $data;
			$this->save($this->data);
		}		
	}

/**
 * get quantity of one product in shopping cart
 *
 */

	public function getQuantity($order_id, $product_id, $subproduct_id) {
		$data = $this->find('first', 
			array('conditions' => 
				array('order_id' => $order_id,
					'product_id' => $product_id,	
					'subproduct_id' => $subproduct_id
				), 'recursive' => -1));
		if(!$data) {
			return '0';
		}
		return $data['LineItem']['quantity'];		
	}

/**
 * add quantity of an existing product
 */

	public function addQuantity($order_id, $product_id, $new_quantity, $subproduct_id) {
		$data = $this->find('first', 
			array('conditions' => 
				array('order_id' => $order_id,
					'product_id' => $product_id,	
					'subproduct_id' => $subproduct_id
				), 'recursive' => -1));
		
		$this->id = $data['LineItem']['id'];
		$this->saveField('quantity', $new_quantity);
	}

/**
 * edit multiple line_item quantities
 */

	public function editQuantities($data) {
		foreach ($data['LineItem'] as $row) {
			if($row['quantity'] == 0) {
				$this->delete($row['id']);
			} else {
				$this->recursive = -1;
				$this->id = $row['id'];
				$this->saveField('quantity', $row['quantity']);
				
			}
		}
	}

/**
 * 
 */

	public function convert($data) {
		foreach ($data as $row) {
			$row['product'] = $row['Product']['name'];
			$row['subproduct'] = $row['Subproduct']['name'];
			$this->save($row);
		}
	}

/**
 * Stock controller
 * Removes stock from the inventory (<code>/subproducts/stock_remove/</code>)
 */

	public function stockControl($data) {
		if(Configure::read('Shop.stock_control') == '1') {
			$model = 'Product';
			if(!empty($data['Subproduct']['name'])) {
				$model = 'Subproduct';
			} 
			$array = strtolower($model);
			ClassRegistry::init($model)->stockRemove($data[$array . '_id'], $data['quantity']);
		}
	}

/**
 * 
 */

	public function generatedOrderInfo($order_id, $data) {
		$subproduct = '';
		if(!empty($data['Subproduct']['name'])) {
			$subproduct = $data['Subproduct']['name'];
		}
		$generated = array(
    		'order_id' => $order_id,
			'product_id' => $data['Product']['id'],
			'product' => $data['Product']['name'],
			'subproduct' => $subproduct,
			'quantity' => $data['quantity'],
			'price' => $data['price']
		);
		return $generated;
	}
}
?>