<?php

/**
 * Files component
 *
 * @package BakeSale
 * @version $Id: files.php 497 2007-08-06 12:02:37Z drayen $
 */

class FilesComponent extends Object
{
	public $controller;
	public $maxsize = 1000;
	public $_allowedImageExtensions = array("jpg", "jpeg", "gif", "png");
	private $_duplicateCount = 0;

/**
 * Get access to controller
 */

    public function startup(&$controller) {
        $this->controller =& $controller;
    }


	private function _setFileName($fileName) {
		$this->fileName = $fileName;
	}	

	private function _setUploadFolder() {
		$this->uploadFolder = WWW_ROOT . IMAGES_UPLOAD_FOLDER . DS;
	}	
	
	private function _setSeoFileName() {
		$this->seoFileName = self::rewriteFileName($this->_getItemName());
		$this->seoFileName = $this->seoFileName . '.' . $this->fileExtension;	
		$this->_getFileNameCounter();
	}	

	private function _setFileExtension() {
		$extension = $this->fileName;
		if(strstr($this->fileName, '.')) {
			$pieces = explode(".", $this->fileName);
			$extension = $pieces[count($pieces) - 1];
		}
		$this->fileExtension = strtolower($extension);
	}	

	private function _setModel($model) {
		$this->model = $this->controller->modelClass;	
	}	

	private function _setId($id) {
		$this->id = $id;	
	}	

	private function _setField($field) {
		$this->field = $field;	
	}	
	
	private function _setType($type) {
		$this->type = $type;	
	}	

/**
 * Save file to server
 *
 * @param $fileData
 * @param $fileName
 * @param $folder
 */

	public function saveAs($fileData, $fileName, $folder) {
		if (is_writable($folder)) {
			if (is_uploaded_file($_FILES[$fileData]['tmp_name'])) {
				if(move_uploaded_file($_FILES[$fileData]['tmp_name'], $folder.DS.$fileName)){
					return true;
				}
			} 
		}
		return false;
	}

/**
 * Delete file from server
 *
 * @param $fileName
 * @param $folder
 */

	public function delete($fileName, $folder) {
		if (unlink($folder.$fileName)) {
			return true;
		}
		return false;
	}
	
	

/**
 * Check for valid file type extension
 *
 * @param $fileName
 * @param $field
 */

	private function _isValidFileType() {
		if($this->field != 'images') {
			return true;
		}
		if (in_array($this->fileExtension, $this->_allowedImageExtensions)) {
			return true;
		} 
		return false;
	}

/**
 * Upload file to server and save data to model
 *
 * @param $data
 * @param $id
 * @param $model
 * @param $field
 * @param $type
 */

	public function uploadSave($data, $id, $model, $field = 'images', $type = 'multiple') {
		$this->_setFileName($data['name']);
		$this->_setFileExtension();
		$this->_setModel($model);
		$this->_setId($id);
		$this->_setField($field);
		$this->_setType($type);
		$this->_setUploadFolder();
		$this->_setSeoFileName();		
		
		if(!$this->_isValidFileType()) { 
			$image['error']	= 
			sprintf(__('Wrong file format. You tried to upload file with type %s. Allowed filetypes are %s', true),  $this->fileExtension, implode(', ', $this->_allowedImageExtensions));	
			return $image;
		}

		if(!$this->saveAs('imageFile', $this->fileName, $this->uploadFolder)) {
			$image['error']	= __('Error saving image');	
			return $image;
		}
		
		$size = $this->_isValidSize();
		if($size) {
			$this->_saveFileToDatabase();
			$image['file'] = $this->fileName;
		} else {
			$image['error']	= __('Image too big.', true) . 
			sprintf(__('Your size: %s, maximum %s', true), $this->getSize($fileName, $this->uploadFolder), $this->maxsize . ' x ' . $this->maxsize);
			$this->delete($this->fileName, $this->uploadFolder);
		}
		return $image;
	}

/**
 * Generate web compatible SEO filename
 *
 */

	private function _getFileNameCounter($count = false) {
		if(is_file($this->uploadFolder . $this->seoFileName)) {
			$count = 0;
			$name = $this->_getFileName($count + 1);
		} else {
			return $name;
		}
	}




/**
 * Check that the filesize is within allowed limits
 */

	private function _isValidSize() {
		$size = getimagesize($this->uploadFolder . DS .$this->fileName);
		$width = $size[0];
		$height = $size[1];
		if($width > $this->maxsize || $height > $this->maxsize){
      		return false;
		}
		return true;
	}

/**
 * TODO
 */

	private function _getImageSize($file, $folder) {
		$size = getimagesize($this->uploadFolder . DS .$this->fileName);
		$width = $size[0];
		$height = $size[1];
		$uploadSize = $width . ' x ' . $height;
      	return $uploadSize;
	}

/**
 * Clean string
 *
 * @param $name
 */

	static function rewriteFileName($name) {
		$name = strtolower($name);
		$name = str_replace("_", "-", $name);
		$name = str_replace(" ", "-", $name);
		$name = str_replace("---", "-", $name);
		$name = ereg_replace('[^[:alnum:] ]','-', $name);
		$name = str_replace("--", "-", $name);
		return $name;		
	}

/**
 * Save file info to database TODO
 *
 * @param $image
 */

	private function _saveFileToDatabase($image) {
		$model = ClassRegistry::init($this->model);
		$data = $model->findById($this->id);
		$images = $data[$this->model][$this->field] . ';' . $image;		
		if(($this->type == 'single') || (empty($data[$this->model][$this->field]))) {
			$images = $image;
		}
		$data2['id'] = $this->id;
		$data2[$this->field] = $images;
		$model->save($data2);
	}

/**
 * Save file info to database
 */

	private function _getItemName() {
		$data = ClassRegistry::init($this->model)->findById($this->id);
		return $data[$this->model]['name'];		
	}


}
?>