<?php

/**
 * product.php
 *
 * @author Matti Putkonen,  matti.putkonen@fi3.fi
 * @copyright Copyright (c); 2006-2009, Matti Putkonen, Helsinki, Finland
 * @package BakeSale
 * @version $Id: product.php 508 2007-09-20 10:23:20Z matti $
 */
class Product extends AppModel
{

    public $belongsTo = array('Brand');
    public $hasMany = array('Subproduct' =>
                       array('dependent' =>  true,
        	        'order' => 'Subproduct.sort ASC, Subproduct.name ASC'),
            	 'LineItem' =>
                       array('dependent' => true));
    public $hasAndBelongsToMany = array('Category');

	public $validate = array(
    'name' => array(
    	'notEmpty' => array(
            'required' => true,
        'rule' => 'notEmpty',  
        'message' => 'Name is required',
        'on' => 'edit',
    	),  
    ),
	);

/**
 *
 */

	public function afterFind($data){
    if(isset($data[0]['Product']['images'])) {
    	if(!empty($data[0]['Product']['images'])) {
        $images = explode(";", $data[0]['Product']['images']);
        $data[0]['Product']['image_count'] = count($images);
        $data[0]['Product']['main_image'] = $images[0];
        unset($images[0]);
        $data[0]['Product']['extra_images'] = $images;
    	} else {
        $data[0]['Product']['image_count'] = '0';
        $data[0]['Product']['main_image'] = 'error.png';
        $data[0]['Product']['extra_images'] = array();

    	}
    }
    return $data;
	}

/**
 * update product quantity
 * @param $id int Product id
 */
	
	function stockRemove($id, $quantity) {
    if (!empty($this->params['requested'])) {
    	$data = $this->read(null, (int)$id, -1);
    	$new_quantity = $data['Product']['quantity'] - (int)$quantity;
    	$this->saveField('quantity', $new_quantity);
    	if ($new_quantity < '1') {
        $this->_soldout((int)$id);
    	}
    	$quantity = $new_quantity;
    }
    return $quantity;
    }

/**
 * Execute on soldout action
 * Method used for stock maintenance (see stock_remove()).
 * @param $id int Product id
 */	
 
	private function _soldout($id) {	
    $field = Configure::read('Shop.on_soldout');
    $this->data['Product'] = array(
        	'id' => (int)$id,
        	$field => '0'
    );
    $this->Product->save($this->data);
    }
}
?>