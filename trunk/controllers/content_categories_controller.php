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
 * @version $Id: content_categories_controller.php 502 2007-09-07 03:21:24Z matti $
 */
 
/**
 * Manages content categories
 */

class ContentCategoriesController extends AppController
{

/**
 * Displays the main content_category menu.
  */

    public function menu($id = 0) {
        return $this->ContentCategory->__menu('flat', (int)$id);
    }

/**
 * Display category.
 */

    public function show($id = 0) {
        $this->cacheAction = true;
        $this->data = $this->ContentCategory->bsFindOneActive(1, compact('id'));
    }

/**
 * Adds a new content category to the store.
 */

    public function admin_add() {
        $this->_addEditInfo();
        parent::admin_add();
    }

/**
 * Edits information on a content_category.
 *
 * @param id int
 * The ID field of the content_category to edit.
 */

    public function admin_edit($id) {
        parent::admin_edit($id);
        $this->_addEditInfo();
    }

/**
 * Shared information between add and edit views
 */

    private function _addEditInfo() {
        $parents = $this->ContentCategory->find('list'); 
        $this->set(compact('parents'));
    }

/**
 * Displays all categories in the admin page.
 *
 * The content_categories are retrieved for display on screen. Makes use of the parent-child relationship of content_categories.
 */

    public function admin_menu() {
        return $this->ContentCategory->_menu('admin_full');
    }

}
?>