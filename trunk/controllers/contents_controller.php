<?php

/**
 * BakeSale shopping cart
 * Copyright (c)	2006-2009, Matti Putkonen
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @author Matti Putkonen,  matti.putkonen@fi3.fi
 * @copyright    Copyright (c) 2006-2009, Matti Putkonen
 * @link    	http://bakesalepro.com/
 * @package    	BakeSale
 * @license    	http://www.opensource.org/licenses/mit-license.php The MIT License
 * @version $Id: contents_controller.php 463 2007-07-11 11:18:42Z matti $
 */

/**
 *  Contents controller
 */

class ContentsController extends AppController
{

    public $components = array('Search');
    public $paginate = array('limit' => 100, 'page' => 1); 

/**
 * Show all active contents in the shop.
 *
 * Active contents are defined by the following conditions: <code>Content.active != 2</code> and <code>Content.menu = </code>.
 */

    public function index($id = false) {
        $conditions = array('Content.active' => '1');
        if($id) {
            $conditions = array_merge($conditions, array('content_category_id' => $id));
        }
        return $this->Content->find('all', compact('conditions'));
    }

/**
 * Displays a single content in the shop.
 *
 * This action is stored in session (<code>addUrl()</code>).
 *
 * @param id int The ID of the content in the shop.
 */
 
    public function show($id) {
        $this->data = $this->Content->read(null, $id);
        if (!empty($this->data['Content']['url']) && !isset($this->params['requested'])) {
            $this->redirect($this->data['Content']['url']);
        }
        if (isset($this->params['requested'])) {
            return $this->data;
        } 
    }

/**
 * Show all active contents in the shop.
 *
 */

    public function admin_index($id = false) {
        if($id) {
            $conditions = array('Content.content_category_id' => $id);
            $this->data = $this->Content->find('all', compact('conditions'));
        }
    }

/**
 * Adds new content
 *
 */

    public function admin_add() {
        parent::admin_add();
        $this->_addEditInfo();
    }

/**
 * Edits content.
 *
 * After the content is edited successfully, the user is redirected back to the <em>previous</em> URL. If not an error message is displayed.
 * @param id int The ID field of the content to edit.
 */
 
    public function admin_edit($id) {
        parent::admin_edit($id);
        $this->_addEditInfo();
    }

/**
 * Set shared info for add and edit views.
 *
 */
 
    private function _addEditInfo() {
        $contentCategory = ClassRegistry::init('UserCategory')->find('list');
        $this->set(compact('contentCategory'));
    }

/**
 * get search results
*/

    function search($keywords = '') {
        $searchFields = array('Content.name', 'Content.description');
        return $this->Search->query($this->Content, $keywords, $searchFields, ALL, ANYWHERE);
    }

/**
 * get recent contents
 */

    function recent($limit = 5) {
		$order = 'Content.id DESC';
        return $this->Content->find('all', compact('limit', 'order')); 
    }

}

?>