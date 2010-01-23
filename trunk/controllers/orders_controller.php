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
 * @version $Id$
 */

 
class OrdersController extends AppController
{

    public $name = 'Orders';
    public $uses = array('Order', 'LineItem', 'ShippingMethod', 'PaymentMethod', 'Country');
    public $components = array('Email', 'Search');
    public $helpers = array('Time');
    public $email;
	public $paginate = array('limit' => 30, 'page' => 1, 'order' => array('number' => 'desc')); 
	public $billingFields = array('firstname', 'lastname', 'phone', 'email', 'address', 'postcode', 'city', 'state');

	public $shippingFields = array('firstname', 'lastname', 'address', 'postcode', 'city', 'state');

	
/**
 * Set up required cart info
 */

	public function beforeFilter () {
		parent::beforeFilter();
		if(!$this->Session->check('Order.country_id')) {
			$country_id = $this->Country->getDefaultId();
			$data['Order'] = array(
				'session' => $this->Session->read('Config.rand'),
				'country_id' => $country_id,
				'shipping_method_id' => $this->Country->getShippingMethodId($country_id),
				'payment_method_id' => $this->PaymentMethod->getDefaultId(),
			);
			if($this->Session->check('Order')) {
				$data = array_merge($data['Order'], $this->Session->read('Order'));
			}
			$this->Session->write('Order', $data);
		}
	}

/**
 * Lists all orders in the administrator page.
 *
 * Uses the PaginationComponent class to do the pagination.
 */
 
    public function admin_index($firstLetter = false) {
		$firstLetters = $this->Order->getFirstLetters('lastname');
		$conditions = array_merge(
			$this->Order->getAlphabetConditions($firstLetter, 'lastname'),
			array('session' => '')
		);
		$this->data = $this->paginate('Order', $conditions);
		foreach($this->data as $key => $row) {		
			$this->data[$key] = $this->Order->countTotal($row);
		}
		$this->set(compact('firstLetters'));
    }

/**
 *
 */
 
    public function admin_search($keywords = '') {
		$keywords = $this->params['url']['keywords'];
		$searchFields = array('Order.email', 'Order.firstname', 'Order.lastname', 'Order.number');
		$data = $this->Search->query($this->Order, $keywords, $searchFields, ANY, ANYWHERE, '*', 500);
		$this->set(compact('data'));
    }

/**
 * Edit order
 *
 */
 
    public function admin_edit($id) {
		$this->data = $this->Order->finalized($id);
    }

/**
 * Get cart contents with totals
 */

	public function cart_contents () {
		if($this->Order->fullBySession()) {
			return $data;
		}
	}

/**
 * Show shopping cart page
 */

	public function show () {
		$this->data = $data = $this->cart_contents();
		$this->set(compact('data'));
	}

/**
 * show checkout page
 */

	public function checkout($id = false) {
		$httpsUrl = Configure::read('Site.https_url');
		if(!empty($httpsUrl)) {
			$this->redirect($httpsUrl . '/orders/checkout/');
		}
		if (!empty($this->data)) {
			$this->data['Order']['session'] = $this->Session->read('Order.session');
			$this->Session->write('Order', $this->data['Order']);
			
			$action = 'process';
			if(isset($_POST['verify'])) {
				$action = 'checkout';
				$this->redirect(array('action' => $action));
			} else {
				if($this->Order->save($this->data)) {
					if($this->data['Order']['same'] == '1') {
						$this->_billingToShipping();
					}
					$this->_refreshOrder();
					$this->process($this->data);
				}
			}
			
		} 
		$this->_indexVariables();
    }

/**
 * Set view variables for checkout page
 */
 
	private function _indexVariables() {
		$this->data['Order'] = $this->Session->read('Order');
		$data = $this->cart_contents();
		if($data) {
			$countries = $this->Country->find('list', array('conditions' => array('active' => '1')));
			$country = $this->Country->getCountryData($this->data['Order']['country_id']);
			$country['ShippingMethod'] = $this->ShippingMethod->getAllQuotes($country['ShippingMethod'], $data);
			$paymentMethods = $this->PaymentMethod->bsFindAllactive();
			$shippingFields = $this->shippingFields;
			$billingFields = $this->billingFields;
			$this->data = array_merge($data, $this->data);
			$this->set(compact('data', 'countries', 'paymentMethods', 'country', 'shippingFields', 'billingFields'));
		} else {
			$this->redirect(array('action' => 'show'));
		}
	}

/**
 * Check where to redirect after submitting the checkout form
 */
 
    public function process($data) {
	    $cart = $this->cart_contents();
		$data = array_merge($cart['Order'], $data['Order']);
		$processor = $this->PaymentMethod->getProcessor($data['payment_method_id']);
		if(isset($processor['model'])) {
			$error = classRegistry::init('Payment.' . $processor['model'])->chargeCard($data);
			if(!$error) {
				$this->redirect(array('action' => 'success'));				
			}
		} else {
			$this->redirect(array('plugin' => 'payment', 'controller' => $processor['name'], 'action' => 'index'));
		}
	}

/**
 * Finalize order
 */
 
    public function success() {
		$data = $this->cart_contents();
		$this->set(compact('data'));
		if(!empty($data)) {
			$data['Order'] = array_merge($data['Order'], $this->Session->read('Order'));
			$data['Order']['session'] = '';
			if(Configure::read('Shop.verify_order_automatically') == '1') {
				$data['Order']['verified'] = '1';
			}
			$data['Order'] = $this->Order->convert($data['Order']);
			$data['Order']['session'] = '';
			$this->Order->save($data);
			$this->LineItem->convert($data['LineItem']);
			$this->data = $data;
			$this->_emailOrder($data['Order']['id']);
		}
	}




/**Mails the order information.
 *
 * This function sends a mail to both the customer (email as specified in the
 * order) and the shop owner.
 *
 * @param int $id Order ID. This ID is used to retrieve the order information
 * from the database. The information is then sent via email to the shop owner
 * and the customer.
 */
 
	private function _emailOrder($id) {
		$data = $this->Order->finalized($id);
		$this->_sendEmail($data, Configure::read('Site.email'), $data['Order']['email']);
		$this->_sendEmail($data, $data['Order']['email'], Configure::read('Site.email'));
		$extraEmails = Configure::read('Shop.extra_order_email');
		if(!empty($extraEmails)) {
			$this->_sendEmail($data, $data['Order']['email'], $extraEmails);
		}
	}


/**
 * Sends email confirmation.
 *
 * Private method used for sending one order confirmation email (see email_order()). 
 *
 * @param $data mixed The array of order information to send to the recipient.
 * @param $from string The sender's email address.
 * @param $to string The recipient's email address.
 */
 

	private function _sendEmail($data, $from, $to) {
			$this->Email->to = $to;
        	$this->Email->subject =  __('Order confirmation', true) . ' : ' . $data['Order']['number'];
        	$this->Email->replyTo = $from;
        	$this->Email->from = $from;
			$this->Email->template = 'order_confirmation';
        	$this->set(compact('data')); 
			$this->Email->send();
	}

/**
 *
 */
 
	private function _refreshOrder() {
		$temp = $this->Order->find('first', array('conditions' => array('Order.session' => $this->Session->read('Order.session'))));
		$this->Order->id = $temp['Order']['id'];
		$this->data['Order'] = array_merge($temp['Order'], $this->Session->read('Order'));
		$this->Order->save($this->data['Order']);
	}

/**
 *
 */
 
	private function _billingToShipping() {
		$billingFields = array_merge($this->billingFields, array('country_id'));
		foreach($billingFields as $row) {
			$this->Session->write('Order.s_' . $row, $this->Session->read('Order.' . $row));
		}
	}

}

?>