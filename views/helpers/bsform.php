<?php

/**
 *
 */

class BsformHelper extends Helper {
	public $helpers = array('Form', 'Html', 'Seo', 'Price', 'Session');

/**
 * Generate HABTM complex
 */

	public function habtm($fieldName, $options, $selected = null, $legend) {
    $complex = '<fieldset id="' . $this->humanReadable($fieldName, 'true') . '" class="habtm">';
    $complex .= '<legend>' . $legend . '</legend>';
    $complex .= $this->checkboxMultiple($fieldName, $options, $selected);
    $complex .= '</fieldset>';
    return $complex;
	}


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
 * Returns a list of checkboxes.
 *
 * @param string $fieldName Name attribute of the SELECT
 * @param array $options Array of the elements (as 'value'=>'Text' pairs)
 * @param array $selected Selected checkboxes
 * @param array $htmlAttributes Array of HTML options
 * @param array $containerAttributes Array of HTML attributes used for the containing tag
 * @param boolean $showEmpty If true, the empty checkbox option is shown
 * @param  boolean $return         Whether this method should return a value
 * @return string List of checkboxes
 */
    public function checkboxMultiple($fieldName, $options, $selected = null, $htmlAttributes = null, $containerAttributes = null, $showEmpty = true, $return = false) {

# Tag template for a input type='checkbox ' tag.
$checkboxmultiple = '<input type="checkbox" name="data[%s][%s][]" %s/>%s';

# Tag template for an input type='hidden' tag.
$hiddenmultiple = '<input type="hidden" name="data[%s][%s][]" %s/>'; 
    	
            $this->setFormTag($fieldName); 
	        if ($this->Html->tagIsInvalid($this->Html->model(), $this->Html->field())) {
            if (isset($htmlAttributes['class']) && trim($htmlAttributes['class']) != "") {
                $htmlAttributes['class'] .= ' form_error';
            } else {
                $htmlAttributes['class'] = 'form_error';
            }
        }
        if (!is_array($options)) {
            return null;
        }
        if (!isset($selected)) {
            $selected = $this->Html->tagValue($fieldName);
        }
        foreach($options as $name => $title) {
            $optionsHere = $htmlAttributes;
            if (!isset($htmlAttributes['id'])) {
            $optionsHere['id'] = $this->Html->model() . Inflector::camelize($this->Html->field()) . $name;
            }
            $optionsHere['value'] = $name;
            if (($selected !== null) && ($selected == $name)) {
                $optionsHere['checked'] = 'checked';
            } else if (is_array($selected) && array_key_exists($name, $selected)) {
                $optionsHere['checked'] = 'checked';
            }
            $checkbox[] = "<li>" . sprintf($checkboxmultiple, $this->model(), $this->field(), $this->_parseAttributes($optionsHere), $title) . "</li>\n";
        }
        return "\n<ul".$this->Html->parseHtmlOptions($containerAttributes).">\n" . $this->Html->output(implode($checkbox), $return) . "</ul>\n";
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
 
    public function _extraPaymentFields($processor) {
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


/**
 * Generate HABTM complex
 */

	public function habtm2($fieldName, $options, $selected = null, $legend) {
    $complex = '<fieldset id="' . $this->humanReadable($fieldName, 'true') . '" class="habtm">';
    $complex .= '<legend>' . $legend . '</legend>';
    $complex .= $this->checkboxMultiple2($fieldName, $options, $selected);
    $complex .= '</fieldset>';
    return $complex;
	}

/**
 * Returns a list of checkboxes.
 *
 * @param string $fieldName Name attribute of the SELECT
 * @param array $options Array of the elements (as 'value'=>'Text' pairs)
 * @param array $selected Selected checkboxes
 * @param array $htmlAttributes Array of HTML options
 * @param array $containerAttributes Array of HTML attributes used for the containing tag
 * @param boolean $showEmpty If true, the empty checkbox option is shown
 * @param  boolean $return         Whether this method should return a value
 * @return string List of checkboxes
 */
    public function checkboxMultiple2($fieldName, $options, $selected = null, $htmlAttributes = null, $containerAttributes = null, $showEmpty = true, $return = false) {
        $this->Html->setFormTag($fieldName);
        if ($this->Html->tagIsInvalid($this->Html->model(), $this->Html->field())) {
            if (isset($htmlAttributes['class']) && trim($htmlAttributes['class']) != "") {
                $htmlAttributes['class'] .= ' form_error';
            } else {
                $htmlAttributes['class'] = 'form_error';
            }
        }
        if (!is_array($options)) {
            return null;
        }
        if (!isset($selected)) {
            $selected = $this->Html->tagValue($fieldName);
        }
        if ($showEmpty == true) {
            $checkbox[] = sprintf('<input type="hidden" name="data[%s][%s][]" %s/>', $this->Html->model(), $this->Html->field(), $this->Html->parseHtmlOptions($htmlAttributes));
        }
        foreach($options as $name => $title) {
            $optionsHere = $htmlAttributes;
            if (!isset($htmlAttributes['id'])) {
            $optionsHere['id'] = $this->Html->model() . Inflector::camelize($this->Html->field()) . $name;
            }
            $optionsHere['value'] = $name;
            if (($selected !== null) && ($selected == $name)) {
                $optionsHere['checked'] = 'checked';
            } else if (is_array($selected) && array_key_exists($name, $selected)) {
                $optionsHere['checked'] = 'checked';
            }
    	

            $checkbox[] = "<li>" . sprintf('<input type="checkbox" name="data[%s][%s][]" %s/>', $this->Html->model(), $this->Html->field(), $this->Html->parseHtmlOptions($optionsHere), $title) . 
    	'<label>' . $title . '</label>';
        }
        return "\n<ul".$this->Html->parseHtmlOptions($containerAttributes).">\n" . $this->Html->output(implode($checkbox), $return) . "</ul>\n";
    }
	
/**
 * Generate form end
 */

	public function end($text) {
    $complex = '<div class="buttons">';
    $complex .= '<button type="submit">' . __($text, true). '</button>';
    $complex .= '</div>';
    $complex .= '</form>';
    return $complex;
	}


}
?>
