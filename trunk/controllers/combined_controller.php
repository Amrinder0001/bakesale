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
 * @version $Id$
 */
 
App::import('Vendor', 'cssmin');
App::import('Vendor', 'jsmin');
 
class CombinedController extends AppController {
    public $layout = 'ajax';
    public $autoLayout = false;
    public $uses = array();
    public $schema;
    public $files = array();


/**
 * Set schema
 */

	private function _setSchema($schema) {
		$this->schema = $schema;
	}

/**
 * Set theme
 */

	private function _setTheme($theme) {
		$this->theme = $theme;
	}

/**
 * Set filetype
 */

	private function _setFiletype($filetype) {
		$this->filetype = $filetype;
	}

/**
 * Generate message for file listing
 */

	static function getMessage($data) {
		$message = '/*' . "\n";
		foreach($data as $row) {
    		$message .= ' ' . ltrim($row['path'], WWW_ROOT) . $row['file'] . "\n";
		}
		$message .= '*/' . "\n\n";	
		return $message;
	}


/**
 * Create javascript or CSS files
 */
		
	public function index($schema, $theme) {
		$themeArray = explode(".", $theme);
		$this->_setSchema($schema);
		$this->_setTheme($themeArray[0]);
		$this->_setFiletype($themeArray[1]);
		$this->_setFiles();
		$all = array_unique(array_merge($this->files['basefiles'], $this->files['themefiles']));
		$data = $this->_generateFileArray($all);
		
		$filetype = $this->filetype;
		if($this->filetype == 'js') {
			$filetype = 'Javascript';
		}
		$message = self::getMessage($data);

		$this->set(compact('message', 'data', 'filetype'));
    }

/**
 * Get files
 */
 
	 private function _setFiles() {
			if(strstr($this->schema, '.')) {
				$this->files = $this->_getPluginFileInfo();
			} else if($this->schema == 'manual') {
				$this->files = $this->_getByString();
			} else {
				$this->files = $this->_getBaseFileInfo();
			}
	 }

/**
 * Get file info array for plugin files
 */

	private function _getPluginFileInfo() {
		$data = array();
		if(strstr($this->schema, '.')) {
			$schemaArray = explode(".", $this->schema);
			$schema = $schemaArray[1];
			$data['basepath'] = APP . 'plugins' . DS . $schemaArray[0] . DS . 'webroot' . DS .  $this->filetype . DS;
			$data['themepath'] = $data['basepath'] . $this->theme . DS;
		} else {
			$data['basepath'] = WWW_ROOT . $this->filetype . DS;
			$data['themepath'] = WWW_ROOT . 'themed' . DS . $this->theme . DS . $this->filetype . DS;
		}
		$data['basefiles'] = $this->_findFiles($data['basepath'], $this->schema, $this->filetype);
		$data['themefiles'] = $this->_findFiles($data['themepath'], $this->schema, $this->filetype);
		return $data;
	}

/**
 * Get file info array for base files
 */

	private function _getBaseFileInfo() {
		$data = array();
		$data['basepath'] = WWW_ROOT . $this->filetype . DS;
		$data['themepath'] = WWW_ROOT . 'themed' . DS . $this->theme . DS . $this->filetype . DS;
		$data['basefiles'] = $this->_findFiles($data['basepath']);
		$data['themefiles'] = $this->_findFiles($data['themepath']);
		return $data;
	}

/**
 * get list of files from a directory
 */

	private function _generateFileArray($all) {
		$data = array();
		foreach ($all as $key => $row) {
			$data[$key]['file'] = $row;
			$data[$key]['path'] = $this->files['basepath'];
			if(is_file($this->files['themepath'] . $row)) {
				$data[$key]['path'] = $this->files['themepath'];
			}
		}
		return 	$data;	
	}

/**
 * get list of files from a directory
 */

	private function _findFiles($path) {
		App::import('Core', 'Folder');
 
		$base = new Folder($path);
		$files = $base->find($this->schema . '(.*).' . $this->filetype);
		if(($this->schema == 'shop') || ($this->schema == 'admin')) {
			$files = array_merge($base->find('universal_(.+)\.' . $this->filetype), $files);
		} 
		//print_r($files);
				//die($files);

		return $files;	
	}

}
?>