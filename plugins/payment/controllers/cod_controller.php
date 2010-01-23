<?php

class CodController extends PaymentAppController
{

/**
 * Data unique to shop
 */

	public $defaults = array();

/**
 * show form page
 */

	public function index() {
		$this->redirect(array('plugin' => '', 'controller' => 'orders', 'action' => 'success'));
	}

}
?>