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
 * @version $Id: subproducts_controller.php 461 2007-06-28 08:03:44Z matti $
 */

/**
 * @brief Subproducts controller
 *
 */
 
class SubproductsController extends AppController
{

/**
 * Add new subproduct
 */
	
	public function admin_add() {
        if (!empty($this->data)) {
    		$this->data['Subproduct']['sort'] = '0';
        	if($this->Subproduct->save($this->data)) {
        		$this->data['Subproduct']['id'] = $this->Subproduct->getLastInsertID();
        		$this->set('data', $this->data['Subproduct']);
        		$this->viewPath = 'shared';
        	}
    	}
    	if(!$this->RequestHandler->isAjax()) {
    		$this->redirect(array('controller' => 'products', 'action' => 'edit', 'id'=> $this->data['Subproduct']['product_id']));
    	}
    }

}
?>