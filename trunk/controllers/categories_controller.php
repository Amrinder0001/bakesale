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
 */

/**
 * Manages product categories
 *
 */

class CategoriesController extends AppController
{
	
/**
 * Specifies the component classes for this controller.
 *
 * See also the FilesComponent class (<code>controllers/components/files.php</code>).
 */

    public $components = array('Files');

/**
 * Displays category menu.
 *
 */

	public function menu($id = 0) {
		return $this->Category->_menu('flat', (int)$id);
	}

/**
 * Get product from category.
 *
 */

	public function products($id) {
		return $this->Category->find('first', array('conditions' => array('Category.id' => (int)$id), 'recursive' => 1));
	}

/**
 * Display category.
 *
 */

	public function show($id = false) {
		$this->cacheAction = true;
		$this->data = $this->Category->find('first', array('conditions' => array('Category.active' => 1, 'Category.id' => (int)$id)), -1);
		$this->_validateCategory((int)$id);
		$breadcrumbs = $this->Category->getpath((int)$id);
		$this->set(compact('breadcrumbs'));
	}


/**
 * add new category
 */

	public function admin_add() {
		$this->instantAdd();
    }

/**
 * Edits information on a category.
 *
 * @param id int
 * The ID field of the category to edit.
 */

    public function admin_edit($id) {
		parent::admin_edit((int)$id);
		$parents = $this->Category->find('treepath'); 
		$this->set(compact('parents'));
    }

/**
 * Add new image for category
 * @param $id int Category id
 */

	public function admin_add_image($id) {
		$this->viewPath = 'shared';
		$this->layout = 'ajax';
		Configure::write('debug', 0);
		$data = $this->Files->uploadSave($this->params['form']['imageFile'], (int)$id, 'Category', 'images', 'single');
		$this->set(compact('data'));
	}


/**
 * Displays all cateogries in the admin page.
 *
 * The categories are retrieved for display on screen. Makes use of the parent-child relationship of categories.
 *
 */

    public function admin_menu() {
		return $this->Category->_menu('admin_full');
	}
	
/**
 * if using storefronts check that the root category is correct.
 */

    private function _validateCategory($id) {
		$valid = $this->Category->isValidCategory((int)$id);
		if(!$valid) {
			$this->redirect('/');
		}
		return true;
    }

}
?>
