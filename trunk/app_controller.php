<?php

/**
 * The parent class of all controllers in the application.
 *
 * AppController contains some pseudo-protected (i.e. supposed to be used by child classes) methods.
 */

class AppController extends Controller {

	public $components = array('RequestHandler', 'Session', 'Auth', 'Config');
	public $helpers = array('Cache', 'Seo', 'Description', 'Price', 'Bs', 'Bsform', 'Tree', 'Images', 'Hcard');
	public $view = 'BsTheme';
   // public $persistModel = true;  

/**
 * Load configuration file
 */
	
	public function beforeFilter() {
		if($this->Config->setConfiguration()) {
			$this->theme = Configure::read('Site.theme');
			$this->setAuthorization();
			$this->setOrderConfigValues();
			if (!isset($this->params['requested'])) {
				$this->_setDefaults();
				$this->addUrl();
			}
		}
	}

	public function beforeRender() {
		if($this->params['action'] == 'admin_index') {
			$this->{$this->modelClass}->cleanEmpty();
		}
	}

/**
 *
 */
	private function setAuthorization(){
		$this->Auth->logoutRedirect = '/';
		$this->Auth->autoRedirect = false;
		$this->Auth->userScope = array('User.active' => 1);
        $this->set('Auth',$this->Auth->user());
		if($this->isAuthorized()) {
			$this->Auth->allow('*');
		} 
    }

/**
 *
 */
	public function isAuthorized(){
		if (isset($this->params["admin"])) {
			if(!$this->isAdmin()) {
				//return false;
			}
		}
		return true;
    }


/**
 *
 */
	public function isAdmin(){
		if(!$this->Session->check('UserCategory')) {
			return false;
		}
		if(!in_array(1, $this->Session->read('UserCategory'))) {
			return false;
		}
		return true;
    }

/**
 *
 */
	public function setOrderConfigValues(){
		$this->Session->write('Order.session', $this->Session->read('Config.userAgent')); 
		$sessionValuesArray = array('id', 'shipping_method_id', 'payment_method_id', 'country_id', 's_country_id', 'session');
		foreach($sessionValuesArray as $row) {
			if($this->Session->check('Order.' . $row)) {
				//Configure::write('Order.' . $row, $this->Session->read('Order.' . $row)); 
			}
		}
    }



/**
 * Set default view variables
 */

	private function _setDefaults() {
		$checked = $selected = '';
		$isAdmin = $hasCart = false;
		if($this->isAdmin()) {
			$isAdmin = true;
		}
		if($this->Session->check('Order.id')) {
			$hasCart = true;
		}
		$this->set(compact('checked', 'selected', 'isAdmin', 'hasCart'));
		
		$this->layout = 'shop';
		if(isset($this->params['admin'])) {
			$this->layout = 'admin';
		}
	}

/**
 * Get URL last added to session
 *
 */

	public function getPreviousUrl() {
		return $this->Session->read('history.current');
	}

/**
 * Adds URL to session.
 *
 * Writes the current URL to a session store <em>HistoryComponent.current</em>. If the variable already exists, it is overwritten by the current URL.
 */

	public function addUrl() {
		$current = $this->params['url']['url'];
		$accept = array('show', 'admin_show', 'admin_index');
		if(in_array($this->action, $accept)) {
			if ($this->Session->read('history.current') != $current){
				//$this->Session->write('history.previous', $this->Session->read('history.current'))->write('history.current', $current);
			}
		}
	}

/**
 * Extension to CakePHP's default 'session flash' behaviour.
 *
 * @param message string Message to display in the session flash message.
 * @param url string URL to redirect to.
 * 	Default: false.
 * @param value string
 * 	If <em>value</em> is true then the <em>value</em> is enclosed in \<strong\> HTML tags along with <em>message</em>.
 * 	Default: false.
 * @param error
 * 	If <em>error</em> is true then the message is enclosed with a \<DIV\> tag with the class selectors <code>fmessage</code> and <code>error</code> i.e. <code>\<div class="fmessage error"\>\</div\></code>\n
 * Default: false.
 */

	public function BsRedirect($message, $url = false, $value = false, $error = false) {
		$message = __($message, true);
		if ($value) {
			$message = sprintf($message, '<strong>' . $value . '</strong>');
		}
		$cssClass = 'confirmation';
		if ($error) {
			$cssClass = 'error';
		}
		$message = '<div class="fmessage ' . $cssClass . '">' . $message . '</div>';
		$this->Session->setFlash($message);
		if ($url) {
			if($url = 'previous') {
				$url = $this->getPreviousUrl();
			}
			$this->redirect('/' . $url);
		}
	}

/**
 * 
 */

	public function _message($message, $url = false, $value = false, $error = false) {
		if(is_array($message)) {
			$messageText = $message['text'];
			$url = $message['url'];
			$value = $message['name'];
			$error = $message['error'];
		} else {
			$messageText = $message;			
		}
		$this->bsRedirect($messageText, $url, $value, $error);
	}

/**
 *
 */

	public function admin_update_multiple() { 
		$this->autoRender = false;
		$modelArray = array_keys($this->data); 
		if($modelArray[0] == '_Token') {
			$modelArray[0] = $modelArray[1];
		}
		if (!empty($this->data)) {
			$message = $this->{$modelArray[0]}->updateMultiple($this->data);
			$this->_message($message, Controller::referer());
		}
	}

/**
 * Generic delete admin function
 */

    public function admin_delete($id = false) {
		if($id) {
			$this->{$this->modelClass}->delete($id);			
		}
		if(isset($this->data)) {
			$this->{$this->modelClass}->delete($this->data[$this->modelClass]['id']);
			$message = $this->modelClass . ' deleted';
			$this->_message($message, array('action' => 'index'));
		} else {
			$this->viewPath = 'shared';
		}
    }

/**
 * sort items 
 */

	    
    public function admin_sort() {
		$model = $this->modelClass;
		$this->autoRender = false;
		foreach ($this->params['url'][$this->params['controller']] as $key => $row){
			$id = str_replace(strtolower($model) . "-", "", $row);
			$this->$model->id = $id;
			$this->$model->saveField($field, $value);
		}
    }

/**Switches the on/off status
 *
 * @param int $id The ID of the item to retrieve.
 * @param string $field The name of the field to toggle.
 */

	
    public function admin_toggle($id, $field = 'active') {
		$model = $this->modelClass;
		$data = $this->$model->findById($id);
		$value = '0';
		if($data[$model][$field] == '0') {
			$value = '1';
		}
		$this->$model->id = $id;
		$this->$model->saveField($field, $value);
	    if(!$this->RequestHandler->isAjax()) {
			$this->redirect($_SERVER['HTTP_REFERER']);
		}
		$this->autoRender = false;
    }

/**
 * Generic admin add function
 *
 */


    public function admin_add() {
        if(isset($this->data[$this->modelClass])) {
			$this->_message($this->{$this->modelClass}->bsSave($this->data, 'add'));
        }
		$this->render('admin_edit');
    }

/**
 * Generic admin edit function
 *
 */


    public function admin_edit($id) {
        if(isset($this->data[$this->modelClass])) {
			$this->_message($this->{$this->modelClass}->bsSave($this->data, 'edit'));
        }
		$this->data = $this->{$this->modelClass}->read(null, $id);
    }

/**
 * Generic admin index function
 *
 */


    protected function instantAdd() {
		$this->redirect(array('action' => 'edit', 'id' => $this->{$this->modelClass}->bsAdd()));
    }
	
/**
 * Generic admin index function
 *
 */

    public function admin_index() {
		$this->data = $this->{$this->modelClass}->find('all');
    }

/**
 * Generic logout function.
 *
 */


    public function logout() {
		$this->redirect(array('plugin' => '', 'controller' => 'users', 'action' => 'logout'));
    }

}
?>