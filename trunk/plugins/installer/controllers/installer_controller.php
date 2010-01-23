<?php

/**
 * BakeSale shopping cart
 * Copyright (c)	2007, Matti Putkonen
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @author          Matti Putkonen,  matti.putkonen@fi3.fi
 * @copyright		Copyright (c) 2007, Matti Putkonen
 * @link			http://bakesalehq.com/
 * @package			BakeSale
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 * @version $Id$
 */

class InstallerController extends InstallerAppController
{
	public $uses = array('Installer.Installer');
	public $layout = 'installer';


/**
 *
 */

	public function beforeFilter() {
		parent::beforeFilter();
		if($this->action != 'index') {
			if(!$this->Session->check('Installer.valid')) {
				$this->redirect(array('action' => 'index'));
			}
		}
	}
	
/**
 *
 */

	public function index() {
		$errors = $this->Installer->getServerErrors();
		if(empty($errors)) {
		    $this->Session->write('Installer.valid', 1);
			$this->redirect(array('action' => 'database'));
		} else {
			$this->set(compact('errors'));
		}
	}

/**
 *
 */

	public function database() {
		if(isset($this->data['Database'])) {
			$this->Installer->generateDatabaseFile($this->data['Database']);
			$this->redirect(array('action' => 'databaseconnection_check'));
		}
	}

/**
 * Confirm database connection and redirect accordingly
 */

	public function databaseconnection_check() {
		uses('model' . DS . 'connection_manager');
		$db = ConnectionManager::getInstance();
		@$connected = $db->getDataSource('default');
			
		$message = 'Error: not able to connect to database';
		$cssClass = 'error';
		$action = 'database';
			
		if ($connected->isConnected()) {
			$message = 'Success: your database connection is now set';
			$cssClass = '';
			$action = 'bakesale';			
		}
		$this->Session->setFlash($message, 'default', array('class' => $cssClass));					
		$this->redirect(array('action' => $action));
	}

/**
 * Refactor: writing the data should be done in config component and themes should be delivered from themes controller/model
 */

	public function bakesale() {
		$themes = ClassRegistry::init('Themes.Themes')->getThemes('list');
		$locales = array('fi' => 'fi', 'en' => 'en');
		$this->set(compact('themes', 'locales'));
		if(isset($this->data)) {
			$this->Config->write('bakesale_config.php', $this->data);
			$this->redirect(array('action' => 'import'));
		}
	}

/**
 */

	public function super_user() {
		if(isset($this->data['User'])) {
			$this->data['User']['active'] = 1;
			$this->data['UserCategory']['UserCategory'] = array(1);
			$this->Session->write('UserCategory', $this->data['UserCategory']['UserCategory']);
			$this->User = ClassRegistry::init('User');
			$id = $this->User->bsAdd($this->data);
			$this->Auth->login($id);
		    $this->redirect(array('action' => 'finished'));
        }		
	}

/**
 *
 */

	public function import() {
		if(isset($this->data)) {
			$this->Installer->runInstallSql($this->data);
			$this->redirect(array('action' => 'super_user'));
		}
	}

/**
 *
 */

	public function finished() {
		$this->Installer->writeConfigFile();
	}
 
/**
 *
 */

	public function runsql($files = array()) {
		if(isset($this->data)) {
			$this->Sql->executeSqlFiles($files, APP . 'docs/sql/');
		}
	}
}
?>