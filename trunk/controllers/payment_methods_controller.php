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
 * @copyright		Copyright (c) 2006-2009, Matti Putkonen
 * @link			http://bakesalepro.com/
 * @package			BakeSale
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 * @version $Id: payment_methods_controller.php 512 2007-10-05 07:12:41Z matti $
 */

class PaymentMethodsController extends AppController
{

	public $components = array('Config');
/**
 * List all payment methods in admin
 */

	public function admin_index() {
		$this->data = $this->PaymentMethod->find('all', array('order' => 'sort asc', 'recursive' => -1));
	}

/**
 * add payment method
 *
 * When submitted, write configuration info to configuration file
 */

	public function admin_add() {
		if(isset($this->data['PaymentMethod'])) {
			$this->data['PaymentMethod']['name'] = $this->data['PaymentMethod']['processor'];
			$this->_refreshProcessors($this->data['PaymentMethod']['processor']);
			$this->redirect(array('action' => 'edit', 'id' => $this->PaymentMethod->bsAdd($this->data)));
		} else {
			$this->set('processors', $this->PaymentMethod->getProcessors());
		}
	}

/**
 * Edit payment method
 *
 * When submitted, write configuration info to configuration file
 *
 * @param $id int PaymentMethod id
 */
	
	function admin_edit($id) {
		if(isset($this->data['paymentConfig'])) {
			$this->Config->write(
				$this->data['PaymentMethod']['processor'],
				array($this->data['PaymentMethod']['processor'] => $this->data['paymentConfig']),
				'payment_methods'
			);
		}
		parent::admin_edit($id);
		$processorData = $this->PaymentMethod->getProcessorData($this->data['PaymentMethod']['processor']);
		$this->set(compact('processorData'));
	}

/**
 *  Write missing payment processor configuration files
 */
 
	private function _refreshProcessors($processor) {
		if(is_file(APP . 'plugins'  . DS . 'payment' . DS . 'controllers' . DS . $processor  . '_controller.php')) {
			$this->requestAction('/admin/payment/' . $processor . '/info');
		} else {
			$this->_writeProcessorModelData($processor);
		}
	}

/**
 *  Get processor data from configuration file
 */

	private function _writeProcessorModelData($processor) {
		$blaah = Inflector::classify($processor);
		$processorData = ClassRegistry::init('Payment.' . $blaah)->processorData();
		$this->Config->write(
			$processor,
			array($processor => $processorData),
			'payment_methods'
		);
	}

/**
 *  Install all payment methods
 */

	public function admin_install_all() {
		$this->PaymentMethod->deleteAll('1 = 1', false);
		$row = $this->PaymentMethod->getProcessors();
		foreach ($processors as $key => $row){ 
			$this->_refreshProcessors($row);
			$this->PaymentMethod->addFromProcessor($row);			
		}
	}

}

?>
