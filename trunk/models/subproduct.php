<?php

/**
 * subproduct.php
 *
 * @author Matti Putkonen,  matti.putkonen@fi3.fi
 * @copyright Copyright (c); 2006-2009, Matti Putkonen, Helsinki, Finland
 * @package BakeSale
 * @version $Id: subproduct.php 246 2006-12-24 13:55:42Z matti $
 */

class Subproduct extends AppModel
{

    public $belongsTo = 'Product';
	public $validate = array(
    'name' => array(
    	'notEmpty' => array(
            'required' => true,
        'rule' => 'notEmpty',  
        'message' => 'Name is required'
    	),  
    ),
	);

/**
 * Remove quantity from stock
 * @param $id int Subproduct id
 */

	public function stockRemove($id, $quantity) {
    	$data = $this->read(null, $id, -1);
    	$new_quantity = $data['Subproduct']['quantity'] - $quantity;
    	$this->saveField('quantity', $new_quantity);
    }
	
}
?>
