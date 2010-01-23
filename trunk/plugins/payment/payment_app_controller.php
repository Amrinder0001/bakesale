<?php

/**
 * Handles communication between the application and individual controllers. 
 * Can get data thru requestactions, sessions or have it hardcoded
 * Below examples are from BakeSale (). Modify as needed.
 */

class PaymentAppController extends AppController 
{

	public $uses = array();   
	public $viewPath = 'shared';
	public $components = array('Config');

/**
 * Set defaults for plugin
 */


	public function _setDefaults () {
    $this->set('checked', '');
    $this->set('selected', '');
    $this->layout = 'ajax';
    $this->set('controller', strtolower($this->name));
    Configure::load('custom/' . strtolower($this->name));
	}


/**
 * Generate data array. Called from individual payment controllers
 */

	public function get_info () {
    $data['Order'] = $this->_getCartInfo();
    $data['Customer'] = $this->_getCustomerInfo();
    $data['Store'] = $this->_getStoreInfo();
    $data['message'] = $data['Customer']['rawAddress'] . "\n\n" . $data['Order']['products'];
    return $data;
	} 

/**
 * get cart contents. if empty redirect to shopping cart page
 */
 
	private function _getCartInfo() {
	    $cart = $this->requestAction('/orders/cart_contents/');
    $data = $cart;
    $data['subtotal'] = number_format($cart['Order']['subtotal'], 2, '.', '');
    $data['id'] = $cart['Order']['id'];
    $data['shipping_handling'] = number_format($cart['Order']['shipping_handling'], 2, '.', '');
    $total = $cart['Order']['total'] + $this->Session->read('Order.state_tax');
    $data['total'] = number_format($total, 2, '.', '');
    $data['raw_total'] = str_replace('.', '', $data['total']);	
    $data['products'] = $this->_getProductsString($data);
    $data['products_array'] = $this->_getProductsArray($data);
    return $data;
	}


/**
 * Get customer info
 */
	
	private function _getCustomerInfo() {
    $data = $this->Session->read('Order');
    
    $data['Country'] = $this->requestAction('/countries/info/' . $data['country_id']);
    $data['ShippingCountry'] = $this->requestAction('/countries/info/' . $data['s_country_id']);
    $data['name'] = $data['firstname'] . ' ' . $data['lastname'];
    $data['s_name'] = $data['s_firstname'] . ' ' . $data['s_lastname'];
    $data['ip'] = $_SERVER['REMOTE_ADDR'];
    $data['rawAddress'] = $data['name'] . "\n" . $data['address'] . "\n" . $data['postcode'] . $data['city'] . "\n\n" . $data['phone'] . "\n" . $data['email'];
    return $data;
	}

/**
 * get store info
 */
 
	private function _getStoreInfo() {
    $data['success_url'] = FULL_BASE_URL . Router::url('/') . 'orders/success/';
    $data['cancel_url'] = FULL_BASE_URL . Router::url('/') .  'orders/checkout/';
    $data['email'] = Configure::read('Site.email');
    $data['name'] = Configure::read('Site.name');
    
    return $data;
	}


/**
 * Create an string from products array
 */
	
	private function _getProductsString($data) {
    $products = '';
    foreach ($data['LineItem'] as $key => $row) {
    	
    	$products .= $row['quantity'] . ' x ' . $row['Product']['name'];
    	if(!empty($row['Subproduct']['name'])) {
        $products .= ' (' . $row['Subproduct']['name'] . ') ';
    	}
    	$products .= ', ';
        }
    $products = substr($products, 0, -2);
    return $products;
	}

/**
 * Create an string from products array
 * @protected
 */
	
	public function _getProductsArray($data) {
    $products = array('');
    foreach ($data['LineItem'] as $key => $row) {
    	$products[$key] = $row['Product'];
    	$products[$key]['url'] = FULL_BASE_URL . Router::url(array('plugin' => '', 'controller' => 'products', 'action' => 'show', 'id' => $products[$key]['id']));
    	
    	$products[$key]['counter'] = $key +1;
    	$products[$key]['quantity'] = $row['quantity'];
    	if($products[$key]['special_price'] != 0) {
        $products[$key]['price'] = $products[$key]['special_price'];
    	}
    	if(!empty($row['Subproduct'])) {
        $products[$key]['name'] = $products[$key]['name'] . ' (' . $row['Subproduct']['name'] . ') ';
        if($row['Subproduct']['price'] != 0) {
        	$products[$key]['price'] = $row['Subproduct']['price'];
        }
    	}
        }
    return $products;
	}

/**
 * set currency setting to gateway
 *
 */

	public function get_currency($options) {
    $currency = $options[0]; 
    if(in_array(Configure::read('Currency.code'), $options)) {
    	$currency = Configure::read('Currency.code'); 
    }
    return $currency;
	}

/**
 * set language setting to gateway
 *
 */

	public function get_language($options) {
    $language = $options[0]; 
    if(in_array(strtoupper(Configure::read('Site.locale')), $options)) {
    	$language = Configure::read('Site.locale'); 
    }    
    return $language;
	}

/**
 * configuration info in admin
 */
	
	public function infoBase($data = false) {
    $controller = strtolower($this->name);
    if(is_file(CONFIGS . DS . 'payment_methods' . DS . $controller)) {
    	Configure::load('payment_methods/' . $controller);
    } else {
    	if($this->Config->write($controller, array($controller => $data), 'payment_methods')){
        Configure::load('custom/' .$controller);
    	}
    }
    $data = Configure::read($controller);
    return $data;
	}

/**
 * 
 */

	public function admin_info() {
    $this->autoRender = false;
    $this->infoBase($this->defaults);
	}

}
?>