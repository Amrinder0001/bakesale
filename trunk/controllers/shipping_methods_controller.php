<?php

/**
 * BakeSale shopping cart
 * Copyright (c)	2006-2009, Matti Putkonen
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @author          Matti Putkonen,  matti.putkonen@fi3.fi
 * @copyright    Copyright (c) 2006-2009, Matti Putkonen
 * @link    	http://bakesalepro.com/
 * @package    	BakeSale
 * @license    	http://www.opensource.org/licenses/mit-license.php The MIT License
 * @version $Id: shipping_methods_controller.php 515 2007-10-15 11:35:02Z matti $
 */

/**
 * @brief Shipping methods controller
 *
 */

class ShippingMethodsController extends AppController
{

/**
 * list all shipping methods
 */

	public function admin_index() {
    	$this->data = $this->ShippingMethod->find('all', array('order' => 'sort asc'), 0);
	}

/**
 * Add new shipping method
 */

	public function admin_add() {
    	$this->instantAdd();
    }

/**
 * edit shipping method
 * @param $id int ShippingMethod id
 */

	public function admin_edit($id) {    
        parent::admin_edit((int)$id);
    	$types = $this->ShippingMethod->_rule_types();
    	$countries = ClassRegistry::init('Country')->find('list');
    	$this->set(compact('countries', 'types'));
    }

}

?>