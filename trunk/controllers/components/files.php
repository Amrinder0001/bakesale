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

	private function _isValidFileType($fileName, $field) {
		if($field != 'images') {
			return true;
		}
		if (in_array($this->_getFileExtension($fileName), $this->_allowedImageExtensions)) {
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
		$itemName = $this->_getItemName($id, $model);
		$fileName = $this->_getFileName($data['name'], $itemName);
		
		if(!$this->_isValidFileType($fileName, $field)) { 
			$image['error']	= 
			sprintf(__('Wrong file format. You tried to upload file with type %s. Allowed filetypes are %s', true),  $this->_getFileExtension($fileName), implode(', ', $this->allowedImageExtensions));	
			return $image;
		}

		if(!$this->saveAs('imageFile', $fileName, WWW_ROOT . IMAGES_UPLOAD_FOLDER)) {
			$image['error']	= __('Error saving image');	
			return $image;
		}
		
		$size = $this->_isValidSize($fileName, WWW_ROOT . IMAGES_UPLOAD_FOLDER);
		if($size) {
			$this->_saveFileToDatabase($id, $fileName, $model, $field, $type);
			$image['file'] = $fileName;
		} else {
			$image['error']	= __('Image too big.', true) . 
			sprintf(__('Your size: %s, maximum %s', true), $this->getSize($fileName, WWW_ROOT . IMAGES_UPLOAD_FOLDER), $this->maxsize . ' x ' . $this->maxsize);
			$this->delete($file, WWW_ROOT . IMAGES_UPLOAD_FOLDER . DS);
		}
		return $image;
	}

/**
 * Generate web compatible SEO filename
 *
 */

	private function _getFileName($fileName, $itemName, $count = '0') {
		$extension = $this->_getFileExtension($fileName);
		$name = $this->_rewriteFileName($this->_rewriteFileName($itemName)) . '-' . $count . '.' . $extension;
		if(is_file(WWW_ROOT . IMAGES_UPLOAD_FOLDER . DS . $name)) {
			$name = $this->_getFileName($fileName, $itemName, $count + 1);
		}
		return $name;
	}

/**
 * TODO
 */

	private function _getFileExtension($fileName) {
		$extension = $fileName;
		if(strstr($fileName, '.')) {
			$pieces = explode(".", $fileName);
			$extension = $pieces[count($pieces) - 1];
		}
		return strtolower($extension);
	}


/**
 * TODO
 */

	private function _isValidSize($file, $folder) {
		$size = getimagesize($folder . DS .$file);
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
		$size = getimagesize($folder . DS .$file);
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

	private function _rewriteFileName($name) {
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
 * @param $id
 * @param $image
 * @param $model
 * @param $field
 * @param $type
 */

	private function _saveFileToDatabase($id, $image, $model, $field = 'images', $type = 'multiple') {
		$this->model = ClassRegistry::init($model);
		$data = $this->model->findById($id);
		if(($type == 'single') || (empty($data[$model][$field]))) {
			$images = $image;
		} else {
			$images = $data[$model][$field] . ';' . $image;		
		}
		$this->model->id = $id;
		$this->model->saveField($field, $images);
	}

/**
 * Save file info to database TODO
 *
 * @param $id
 * @param $model
 * @param $field
 */

	private function _getItemName($id, $model, $field = 'name') {
		$data = ClassRegistry::init($model)->findById($id);
		return $data[$model][$field];		
	}

}
?>