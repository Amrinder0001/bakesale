<?php

/**
 * BakeSale shopping cart
 * Copyright (c)	2006-2009, Matti Putkonen
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @author          Matti Putkonen,  matti.putkonen@fi3.fi
 * @copyright    Copyright (c) 2006-2009, Matti Putkonen
 * @link    	http://bakesalepro.com/
 * @package    	BakeSale
 * @license    	http://www.opensource.org/licenses/mit-license.php The MIT License
 * @version $Id$
 */

  
class UsersController extends AppController
{
    public $paginate = array('limit' => 10, 'page' => 1); 

/**
 * Redirect to normal login without admin prefix
 */

    public function admin_login() {
        $this->redirect(array('action' => 'login', 'admin' => 0));
    }

/**
 * Login user
 */

    public function login() {
        if ($this->Auth->user()) {
            if (!empty($this->data)) {
                $this->User->id = $this->Auth->user('id'); 
                $this->User->saveField('last_login', date('Y-m-d H:i:s'));
                $this->setUserCategories($this->Auth->user('id'));
                $this->redirect('/');
            }
        }
    }

/**
 * Add user categories to session
 */

    private function setUserCategories($id) {
        $user = $this->User->read(null, (int)$id);
        $data = Set::extract($user['UserCategory'], '{n}.id');
        $this->Session->write('UserCategory', (array)$data);
    }

/**
 * Logout user
 */


    public function logout(){  
        $this->Session->delete('UserCategory');
        $this->Session->setFlash("Logged out.");
        $this->redirect($this->Auth->logout());
    } 

/**
 * Show access denied page
 */

    public function access_denied() {
    }

/**
 * Add user in admin
 */

    public function add () {
        if(isset($this->data['User'])) {
            $this->_message($this->User->bsSave($this->data));
        }
        $this->render('edit');
    }

/**
 * Edit user
 */

    public function edit ($id) {
        if(isset($this->data['User'])) {
            $this->_message($this->User->bsSave($this->data));
        }
        $this->_addEditInfo();
        $this->data = $this->User->read(null, (int)$id);
        unset($this->data['User']['password']);
    }

/**
 * Add user in admin
 */

    public function admin_add () {
        $this->_addEditInfo();
        parent::admin_add();
    }

/**
 * edit user
 */

    public function admin_edit ($id) {
        parent::admin_edit($id);
        $this->_addEditInfo();
        unset($this->data['User']['password']);
    }

/**
 * common info required for add and edit actions
 */

    private function _addEditInfo () {
        $countries = ClassRegistry::init('Country')->find('list');
        $userCategories = ClassRegistry::init('UserCategory')->find('list');
        $this->set(compact('countries', 'userCategories'));
    }

/**
 * list all users
 */

    function admin_index($firstLetter = false) {
        $firstLetters = $this->User->getFirstLetters();
        $conditions = $this->User->getAlphabetConditions((string)$firstLetter);
        $this->data = $this->paginate('User', $conditions);
        $this->set(compact('firstLetters'));
    }

}