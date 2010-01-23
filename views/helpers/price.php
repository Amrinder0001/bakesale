<?php

/**
 * Calculate, style and format price
 *
 * @author Matti Putkonen,  matti.putkonen@fi3.fi
 * @copyright Copyright (c); 2006-2009, Matti Putkonen, Helsinki, Finland
 * @package BakeSale
 * @version $Id: price.php 518 2007-10-28 23:40:50Z matti $
 */

class PriceHelper extends Helper
{
	public $helpers = array('Number');

/**
 * Calculate price
 * 
 * @param $data
 * @param $type
 * @param $subproduct_price
 */

	public function format($data, $type = 'flat', $subproduct_price = 0) {	

		if(isset($data['Product'])) {
			$data = $data['Product'];
		}
	
		if($data['special_price'] > 0) {
			$special_price = true;
			$price = $data['special_price'];
		} else {
			$price = $data['price'];
		}
		
		$price = $price + $subproduct_price;

		if($type != 'internal') {
			if(isset($special_price)) {
				$price = $this->_style($data);
			} else {
				$price = $this->currency($price);
			}
		}
		return $price;
    }


/**
 * Calculate price for subproduct
 * 
 * @param $data
 * @param $subproduct_price
 */

	public function subproduct($data, $subproduct_price = 0) {	
		if(isset($data['Product'])) {
			$data = $data['Product'];
		} 
	
		if($data['special_price'] > 0) {
			$special_price = true;
			$price = $data['special_price'];
		} else {
			$price = $data['price'];
		}
		
		if(($subproduct_price != 0)) {
			$price = $price + $subproduct_price;
			$price = $this->currency($price);
		} else {
			$price = '';
		}
		return $price;
    }

/**
 * Add currency formatting
 * 
 * @param $value
 * @return String
 */
 
	public function currency($price = 0, $type = 'html') { 
		if($price > 0) {
			if($type == 'html') {
				$price = $this->Number->currency ($price, Configure::read('Currency.code')); 
			} else {
				$price = $this->currency_format($price);
				$price = $price . Configure::read('Currency.code');
			}
			return $price;
		}
	}

/**
 * Style price complex with special
 *
 * @param $data
 * @return String
 * @protected 
 */

	public function _style($data) { 
		$price = $this->oldprice($data);
		$price .= $this->newprice($data);
		return $price;
	}

/**
 * Style normal price
 *
 * @param $data
 * @return String
 */

	public function oldprice($data) { 
		$price = $this->currency($data['price']);
		if($data['special_price'] > 0) {
			$price = '<del>' . $price . '</del>';
		}
		return $price;
	}


/**
 * Style special price
 *
 * @param $data
 * @return String
 */

	public function newprice($data) { 
		$price = $this->currency($data['special_price']);
		if($data['special_price'] > 0) {
			$price = '<ins>' . $price . '</ins>';
		}
		return $price;
	}

/**
 * TODO
 *
 */

	public function currency_format($price) {
    	return number_format ($price, Configure::read('Currency.decimal_digits'), Configure::read('Currency.decimal_point'), Configure::read('Currency.thousands_point'));          
	}
}
?>