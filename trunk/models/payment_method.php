<?php

/**
 * payment_method.php
 *
 * @author Matti Putkonen,  matti.putkonen@fi3.fi
 * @copyright Copyright (c); 2006-2009, Matti Putkonen, Helsinki, Finland
 * @package BakeSale
 * @version $Id: payment_method.php 500 2007-08-25 15:16:53Z matti $
 */

class PaymentMethod extends AppModel
{

	public $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',  
				'message' => 'Name is required'
			),  
		),
	);

/**
 * get default payment method id
 */

    public function getDefaultId() {
        $data = $this->find('first', array('conditions' => array('active' => '1'), 'order' => 'sort ASC'), -1);
        return $data['PaymentMethod']['id'];
    }

/**
 * get price for payment method
 * @param $id int PaymentMethod id
 */

    public function getQuote($id = false) {
		if(!$id) {
			$id = Configure::read('Order.payment_method_id');
		}
		$data = $this->findById($id);
		return $data['PaymentMethod']['price'];
	}

/**
 * get processor for payment method
 * @param $id int PaymentMethod id
 */

    public function getProcessor($id) {
		$data = $this->findById($id);
		$returnData['name'] = $data['PaymentMethod']['processor'];
		if(is_file(APP . 'plugins'  . DS . 'payment' . DS . 'models' . DS . $returnData['name'] . '.php')) {
			$returnData['model'] = Inflector::classify($returnData['name']);
		}
		return $returnData;
	}

/**
 *  Get processor data from configuration file
 */

	public function getProcessorData($processor) {
		Configure::load('payment_methods/' . $processor);
		$processorData = Configure::read($processor);
		return $processorData;
	}

/**
 *  Get all payment processors
 */
 
	public function getProcessors() {
		$processors = array_merge(
			$this->getProcessorNames('_controller.php'),
			$this->getProcessorNames('.php', 'models')
		);
		$data2 = array();
		foreach($processors as $key => $row) {
			$data_temp = array($row => $row);
			$data2 = array_merge($data2, $data_temp);
		}
		return $data2;
	}

/**
 *  Get list of processor names
 */
 
	private function getProcessorNames($replaceString, $dirPath = 'controllers') {
		$path = APP . 'plugins'  . DS . 'payment' . DS . $dirPath;
		$thtml = new Folder($path);
		$processors = $thtml->find('(.+)\.php');
		$processors = str_replace($replaceString, '', $processors);		
		return $processors;
	}

/**
 *  add new with processor name
 */
 
	public function addFromProcessor($name) {
		$this->data['PaymentMethod']['name'] = $this->data['PaymentMethod']['processor'] = $name;
		$this->data['PaymentMethod']['active'] = '1';
		$this->PaymentMethod->save($this->data);
	}

}

?>