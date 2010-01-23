<?php

/**
 * BakeSale shopping cart
 * Copyright (c)	2006-2009, Matti Putkonen
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright    Copyright (c) 2006-2009, Matti Putkonen
 * @link    	http://bakesalepro.com/
 * @package    	BakeSale
 * @license    	http://www.opensource.org/licenses/mit-license.php The MIT License
 * @version $Id$
 */

class Error extends AppModel
{

	public $useTable = false;
	private $requiredModels = array('Country', 'ShippingMethod', 'PaymentMethod');
	private $errors = array();

/**
 * Check for all errors
 */

    public function getAll($type = 'installed') {
		$this->shouldBeWritable();
		$this->serverShouldHave();
		if($type == 'installed') {
			$this->_checkForExistance();
		}
		return $this->errors;
    }


/**
 * Retrun an array of directories that should be wraitable
 */

	private function _writableDirectories() {
		return	array(
			CONFIGS, 
			CONFIGS . 'storefronts', 
			CONFIGS . 'core.php', 
			WWW_ROOT . IMAGES_UPLOAD_FOLDER, 
			WWW_ROOT . IMAGES_CACHE_FOLDER
		);
	}

/**
 * Check for problems with installed apps
 */

    private function _checkForExistance() {
		foreach($this->requiredModels as $model) {
			$modelRowCount = ClassRegistry::init($model)->find('count');
			if($modelRowCount > 0) {
				$this->errors[]['message'] = String::insert(__('No records for :model:' , true), compact('model'));
				$this->errors[]['solution'] = String::insert(__('Add at least one :model:' , true), compact('model'));
			}
		}
    }

/*
 * check that required directories are writable
 */
 
	private function shouldBeWritable() {
		foreach($this->_writableDirectories() as $key => $directory) {
			if(is_writable($directory)) {
				$this->errors[$key]['message'] = String::insert(__('Warning: :directory is not writable', true), compact('directory'));
				$this->errors[$key]['solution'] = String::insert(__('Solution: change :directory permissions to 775', true), compact('directory'));
			}
		}
	}


/**
 * Check server for required settings and extensions
 */

	private function serverShouldHave() {
		$data = get_loaded_extensions();
		if(!in_array('gd', $data)) {
			$this->errors['gdlib'] = 'Your gdlib is not installed. Image resizing wont work';
		}
			
		if(!in_array('zlib', $data)) {
			$this->errors['gzip'] = 'no gzip';
		}
	}

/**
 *
 */

	public function getServerErrors() {

	}
}
?>