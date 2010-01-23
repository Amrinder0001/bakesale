<?php

/**
 * BakeSale shopping cart
 * Copyright (c)	2006-2009, Matti Putkonen
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright		Copyright (c) 2006-2009, Matti Putkonen
 * @link			http://bakesalepro.com/
 * @package			BakeSale
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 * @version $Id: config.php 512 2007-10-05 07:12:41Z matti $
 */

 
class ConfigComponent extends Object
{
	public $controller;
 
/**
 * Get access to controller
 */

    function startup(&$controller) {
        $this->controller =& $controller;
    }

/**
 * Write configuration file
 */

	public function write($file, $data, $folder = 'storefronts', $arrayKey = 'config') {
		$text = $this->_generateFile($data, $arrayKey);
		$this->writeFile($file, $text, $folder);
	}

/**
 * Create a string of configuration values
 */

	private function generateFile($data, $arrayKey = 'config') {
		$text = '<?php '. "\n\n";
		foreach($data as $key => $row) {
			$text .= "\n\$" . $arrayKey . "['" . $key . "'] = array(" . "\n";
			foreach($data[$key] as $key2 => $row2) {
				$text .= "\t'" . $key2 . "' => '" . $row2 . "',\n";
			}
			$text .= ');';
		}
		$text .= '?>';
		return $text;
	}

/**
 * Write configuration file to disk
 */

	public function writeFile($file, $text, $folder) {
		if(!empty($folder)) {
			$folder = $folder . DS;
		}
		$file = str_replace('.php', '', $file);
		$file_starter = fopen(CONFIGS . DS . $folder . strtolower($file) . '.php', 'w') or die("can't open file");
		fwrite($file_starter, $text);
		fclose($file_starter);
	}

/**
 * Set base configuration
 */

	public function setConfiguration() {
		if(is_file(CONFIGS . 'storefronts' . DS . 'bakesale_config.php')) {
			Configure::load('storefronts/bakesale_config');
			$this->getStoreFrontConfiguration();
			Configure::write('Config.language', Configure::read('Site.locale')); 
			return true;
		} else {
			if($this->params['plugin'] != 'installer') {
				$this->controller->redirect(array('plugin' => 'installer', 'controller' => 'installer', 'action' => 'index'));
			}
		}
	}
	
/**
 * Get storefront configuration
 */

	protected function getStoreFrontConfiguration() {
		$siteArray = explode('/', FULL_BASE_URL);
		$site = $siteArray[count($siteArray) - 1];
		if(is_file(CONFIGS . 'storefronts' . DS . $site . '.php')) {
			require_once(CONFIGS . 'storefronts' . DS . $site . '.php');
			if(!empty($storefront)) {
				$main = array_keys($storefront);
				foreach($storefront as $key => $row) {
					$secondary = array_keys($row);
					foreach($secondary as $key2 => $row2) {
						Configure::write($key . '.' . $row2, $storefront[$key][$row2]);
					}
				}
			}
		}
		return false;
	}

}
?>
