<?php

/**
 * An extended helper class.
 **/

class TreeHelper extends Helper {
	public $tab = "  ";
	
/**
 * Specifies the other helper classes that are used.
 *
 * See also the SeoHelper (<code>views/helpers/seo.php</code>) class and HtmlHelper class (built-in).
 **/
 
	public $helpers = array('Html', 'Seo');

/**
 * TODO
 **/

	public function show($name, $data, $extra = '', $url = '', $form = false, $selected = false) {
		list($modelName, $fieldName) = explode('/', $name);
		$output = $this->_List($data, $extra, $url, $form, $selected, $modelName, $fieldName, 0);
		return $this->output($output);
	}

/**
 * TODO
 **/

	public function flat($name, $data, $selected = null, $legend) {
		list($modelName, $fieldName) = explode('/', $name);
		debug($data);
		$complex = '<fieldset id="' . $fieldName . '" class="habtm">';
		$complex .= '<legend>' . $legend . '</legend>';
		foreach ($data as $key => $row) {
			$this->_generate_input($data, $modelName, $fieldName, $selected);
		}
		$complex .= '</fieldset>';
		return $complex;
	}


/**
 * TODO
 **/

	public function _List($data, $extra, $url, $form, $selected, $modelName, $fieldName, $level) {
		$tabs = "\n" . str_repeat($this->tab, $level * 2);
		$li_tabs = $tabs . $this->tab;

		$output = $tabs. '<ul' . $extra . '>';
		foreach ($data as $key => $row) {
			if($form) {
				$text = $this->_generate_input($row, $modelName, $fieldName, $selected);
			} else {
				$text = $this->_generate_link($row[$modelName], $url);
			}
			if(isset($row['children'][0]) && ($form) && (!in_array($row[$modelName]['id'], $selected))) {
				$text = strip_tags($text, '<label>');
			}			
			$output .= $li_tabs . '<li>' . $text;
			if(isset($row['children'][0])) {
				$output .= $this->_List($row['children'], '', $url, $form, $selected, $modelName, $fieldName, $level+1);
				$output .= $li_tabs . '</li>';
			} else {
				$output .= '</li>';
			}
		}
		$output .= $tabs . '</ul>';
		return $output;
	}

/**
 * TODO
 **/

	public function _generate_input($data, $modelName, $fieldName, $selected) {
		$checked = '';
		if(in_array($data[$modelName]['id'], $selected)) {
			$checked = ' checked="checked"';
		}
		$text = '<input type="checkbox" name="data[' . $modelName . '][' . $modelName . '][]" value="' . $data[$modelName]['id'] . '"' . $checked . ' /><label>' . $data[$modelName][$fieldName] . '</label>';
		return $text;
	}

/**
 * TODO
 **/

	public function _generate_link($data, $url) {
		if(strstr($url, 'admin')) {
			$text = '<a href="' . $this->Html->url($url . $data['id']) . '" class="status-' . $data['active'] . '">' . $data['name'] . '</a>';
		} else {
			$text = '<a href="' . $this->Seo->url($data, 'categories') . '">' . $data['name'] . '</a>';
		}
		return $text;
	}

}
?>