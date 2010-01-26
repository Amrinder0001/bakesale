<?php

/**
 *
 */

class BsformHelper extends Helper {
	public $helpers = array('Form', 'Html', 'Seo', 'Price', 'Session');

/**
 * Generate label or legend
 */

	public function humanReadable($text) {
		if(strstr($text, '/')) {
			$nameArray = explode("/", $text);
			$text = '';
			foreach($nameArray as $row) {
				$text .= ucfirst($row);
			}
		}
		return $text;
	}

/**
 * Returns a list of radio buttons.
 */
    public function generateHanlingChoices($data, $ArrayName = false, $selected = null) {
		$model = Inflector::classify($this->params['controller']);
		$legend = $this->_legend($ArrayName);
		$menu = '';
		$menu .= '<fieldset class="handling" id="' . Inflector::classify($ArrayName) . '"><legend>' . $legend . '</legend>';
		if(count($data) > 1) {
			$menu .= $this->radioGroup($data, $ArrayName, $selected);
		} else {
			if(isset($data[0][Inflector::classify($ArrayName)])) {
				$data = $data[0][Inflector::classify($ArrayName)];
			} else {
				$data = $data[0];        
			}
			$menu .= $this->Form->hidden($model . '.' . $ArrayName . '_id', 
					array('div' => false, 'value' => $data['id'])
			);
			$menu .= '<div class="active">' . $data['name'] . ' <span>' . $this->Price->currency($data['price']) . '</span></div>';
		}
		$menu .= '</fieldset>';
		return $menu;
    }

/**
 * Returns a list of radio buttons.
 */

	public function _legend($text) {
		$text = ucfirst(str_replace("_", " ", $text));
		return __($text, true);
	}
	
/**
 * Returns a list of radio buttons.
 */
 
    public function radioGroup($data, $ArrayName = false, $selected = null) {
		$model = Inflector::classify($this->params['controller']);
		$ArrayModel = Inflector::classify($ArrayName);
		$legend = $this->_legend($ArrayName);
		$radio = '';
		$data2 = array();
		foreach($data as $row) {
			if(isset($row[$ArrayModel])) {
				$row = $row[$ArrayModel];
			}
			$id = $row['id'];
			$data_temp = array($row['name'] . ' <span>' . $this->Price->currency($row['price']) . '</span>' . $this->_extraPaymentFields($row['processor']) => $id);
			$data2 = array_merge_recursive($data2, $data_temp);
		}
		$radio .= $this->Form->input(
			$model . '.' . $ArrayName . '_id', 
			array(
				'type' => 'radio',
				'div' => false,
				'options' => array_flip($data2),
				'legend' => false,
				'after' => '</div>',
				'before' => '<div class="handling-item">',
				'separator' => '</div><div class="handling-item">'
			)
		);
		return $radio;
    }


/**
 *  TODO
 */
 
    private function _extraPaymentFields($processor) {
		$extra = '';
		if(is_file(APP . 'plugins'  . DS . 'payment' . DS . 'models' . DS . $processor . '.php')) {
			$extra = '<div class="credit-card">';
			$extra .= $this->Form->input('Order.CreditCard.number');
			$extra .= $this->Form->input('Order.CreditCard.type');
			$extra .= $this->Form->input('Order.CreditCard.year');
			$extra .= $this->Form->input('Order.CreditCard.month');
			$extra .= '</div>';
		}
    return $extra;
	}

/**
 * Returns a list of subproducts in select.
 */
 
    public function subproducts($data, $type = 'select') {
		$text = '';
		if (!empty($data['Subproduct'])) {
			$text .= '<select name="data[LineItem][subproduct_id]"  id="shoppingcart_item_id">';
			foreach($data['Subproduct'] as $row) {
				$disabled = '';
				if($row['quantity'] == '0' && Configure::read('Shop.stock_control') == 1) {
					$disabled = ' disabled="disabled"';
				}
				$text .= '<option value="' . $row['id'] . '"' . $disabled . '>' . $row['name'] . ' ' . $this->Price->currency($row['price']);
			 	$text .= '</option>';
			}
			$text .= '</select>';
		} else {
			$text .= '<input name="data[LineItem][subproduct_id]" type="hidden" value="0" />';    	
		}
		return $text;
	}

}
?>
