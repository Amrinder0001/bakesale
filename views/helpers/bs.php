<?php

/**
 *
 */

class BsHelper extends Helper {
	public $helpers = array('Form', 'Html', 'Seo', 'Price', 'Session', 'Images');

/**
 * set model name
 */
 
	private function _setModel($model = false) {
		if(!$model) {
			$this->model = $this->params['models'][0];
		} else {
			$this->model = $model;
		}
		return $this->model;
	}

/**
 * set controller name
 */
 
	private function  _setController($controller = false) {
		if(!$controller) {
			$this->controller = Inflector::tableize($this->model);
		} else {
			$this->controller = $controller;
		}
		return $this->controller;
	}

/**
 * set action name
 */

	private function _setAction($action = 'edit') {
		return $this->action = $action;
	}

/**
 * set links css class name string
 */
 
	private function  _setLinkCssClass() {
		return $this->linkCssClass = Inflector::tableize($this->model);
	}

/**
 * set link anchor text 
 */
 
	private function  _setLinkText($text = false) {
		if(!$text) {
			$text = ucfirst($this->action) . ' ' . strtolower($this->model);
		}
		return $this->linkText = __($text, true);

	}

/**
 * set id
 */
	private function _setId($data = false) {
		if(!$data) {
			$data = $this->data;
		}
		return $this->id = $data['id'];
	}

/**
 * set data array
 */

	private function _setData($data) {
		if(isset($data[$this->model])) {
			$data = $data[$this->model];
		}
		return $this->data = $data;
	}

/**
 * set link url
 */

	private function _setUrl() {
		$this->url = array(
			'controller' => $this->controller,
			'action' => $this->action,
			'id' => $this->id
		);
		return $this->url;
	}

/**
 * Generate row id for admin index tables
 */

	public function rowId($data, $model = false) {
		$this->_setModel($model);
		$this->_setData($data);
		$this->_setId();
		return strtolower($this->model) . '-' . $this->id;
	}

/**
 * Generate edit link for admin index tables
 * 
 */

	public function tLink($text, $options = array()) {
		$text = __($text, true);
		return $this->Html->link($text, $options);
	}

/**
 * Generate edit link for admin index tables
 */

	public function addLink($id = '', $controller = '') {
		if(empty($controller)) {
			$controller = $this->params['controller'];
		}
		$link = $this->Html->link(
			__('Add ' . strtolower(Inflector::singularize(Inflector::humanize($controller))), true),
			array('controller' => $controller, 'action' => 'add', 'id' => $id),
			array('class' => 'add')
		);
		return $link;
	}


/**
 * Generate edit link for admin index tables
 */

	public function editLink($data, $model = false) {
		$this->_setModel($model);
		$this->_setController();
		$this->_setAction();
		$this->_setData($data);
		$this->_setId();
    	return $this->_link();
	}


/**
 * Generate delete link
 */

	public function deleteLink($data) {
		$this->_setModel();
		$this->_setController();
		$this->_setId($data);
		$this->_setData($data);
		$this->_setAction('delete');
	
		if(!isset($this->data['name'])) {
			$this->data['name'] = $this->data['id'];
		}
		$id = $this->id;
		$action = 'delete';
		$url = $this->Html->url(compact('controller', 'action', 'id'));
		$form = $this->Form->create(array('url' => $url));
		$form .= $this->Form->input($this->model .'.id', array('value' => $this->id));
		$form .= $this->Form->end(__('Delete', true));
		return $form;
	}

/**
 * Generate edit link for admin index tables TODO
 * 
 */

	private function _link() {
		$action = $this->action;
		$link = Router::url(compact('controller', 'action', 'id'));
		$linkText = $this->data['name'];
		$linkClass = strtolower($this->model . ' ' . $this->action);
		return '<a href="' . $link . '" class="' . $linkClass . '">' . $linkText . '</a>';
	}

/**
 * Generate edit link for admin index tables TODO
 * 
 */

	public function link($action = 'edit') {
		return $this->Html->link(__(ucfirst($action), true), array('action' => $action, 'id' => $this->data[$this->params['models'][0]]['id']), array('class' => $action));
	}

/**
 * Generate admin link for shop view
 */

	public function adminMainLink($isAdmin = false) {
		if ($isAdmin) {
			return $this->Html->link('Admin', '/admin/', array('class' => 'admin show'));
		}
		return false;
	}


/**
 * Generate activate link for admin index tables TODO
 * 
 */

	public function adminLink($id = false, $model = false,  $action = 'edit') {
		$this->_setModel($model);
		$this->_setController();
		$this->_setAction($action);
		$this->_setLinkText();

		if ($this->Session->check('Admin')) {
			if(!$id) {
				if(isset($this->params['pass'][0])) {
					$id = '';
					if(is_numeric($this->params['pass'][0])) {
						$id = $this->params['pass'][0];
					}
				}
			}
			
			$admin = true;
			return $this->Html->link(
				$this->linkText,
				compact('admin', 'controller', 'action', 'id'),
				array('class' => 'admin ' . $this->action)
			);
		}
	}

/**
 * Generate activate link for admin index tables TODO
 * 
 */

	public function activateLink($data, $model = false) {
		$this->_setModel($model);
		$this->_setController();
		$this->_setData($data);
		$this->_setAction('toggle');
		$this->_setId();
		$alt =  __('Activate', true);
		if($this->data['active'] == '1') {
			$alt = __('Deactivate', true);
		}
		$plugin = false;
		return $this->Html->link(
			$this->Html->image('/img/icons/icon_' . $this->data['active'] . '.gif', array('alt' => $alt)),
			$this->_setUrl(),
			array('class' => 'status', 'escape' => false)
		);
	}


/**
 * Create admin page header TODO
 * 
 */

	public function pageHeader($linkify = false, $url = false) {
		$cssClass = $name = $prefix = $text = $extra = '';
		$controller = $this->params['controller'];
		$singleController = Inflector::singularize($controller);
		$model = Inflector::classify($this->params['controller']);
		if(!empty($this->params['models'][0])) {
			$model = Inflector::classify($this->params['models'][0]);
		}
		switch ($this->action){
			case 'admin_show':
				$text = $this->data[$model]['name'];
				if(isset($this->data[$model]['active'])) {
					$cssClass = ' class="status-' . $this->data[$model]['active'] . '"';					
				}
			break; 
			case 'admin_index':
				$text = ucfirst($controller);
			break; 
			case 'admin_add':
				$text = $singleController;
				$prefix = 'Add ';
			break; 
			case 'admin_edit':
				$cssClass = ' class="edit"';
				$prefix = 'Edit ';
				$text = strtolower($singleController);
				$deleteLink =  $this->deleteLink($this->data[$model]);
				$viewLink =  '';
				if($linkify) {
					if(!$url) {
						$url = array(
							'admin' => false,
							'action'=>'show',
							'id' => $this->data['id']
						);
					}
					$viewLink = $this->Html->link(__('Shop view', true), $url);
				}
				$name = ' : ' . $this->data['name'];
				$extra = $viewLink . ' ' . $deleteLink;
			break;
			case 'admin_delete':
				$prefix = 'Delete ';
				$text = strtolower($model);    
			break; 
		}
		$text = $text = str_replace("_", " ", $text);
		$text = __($prefix  . $text, true);
		$content = '<h1' . $cssClass . '>' . $text . $name . '</h1>' . $extra;
		//if ($this->action == 'edit') {
			$content = '<div class="page-header">' . $content . '</div>';
		//}
		return $content;
	}


/**
 * Generate image upload form
 * 
 */
    
	public function imageUpload($id) {
    	return $this->fileUploadForm(false, 'Add image', 'add_image');	
	}

/**
 *  TODO
 */

	public function fileUploadForm($id, $label, $action) {
		$text = $this->Form->create(array('action' => $action, 'enctype' => 'multipart/form-data'));
		$text .= $this->Form->inputs(array('legend' => __($label, true), 'file' => array('type' => 'file', 'name' => 'imageFile')));
		$text .= '<button type="submit" class="add">' . __($label, true) . '</button>';
		$text .= '</form>';	
		return $text;
	}

/**
 *  TODO
 */
 
    public function productArray($data, $model = 'Product') {
		$dateTemp = array();
		$this->_setModel($model);
		if(!empty($data) && (!isset($data[$this->model]))) { 
			$dateTemp = $this->_formatArray($data);
		}
	 
		if(!empty($data[$this->model])) { 
			foreach ($data[$this->model] as $key => $row) {
				if($row['active'] != '1') {
					unset($data['Product'][$key]);
				} else {
					$dateTemp[$key] = $row;
					$dateTemp[$key]['link'] = $this->Seo->url($row);
					$dateTemp[$key]['price'] = $this->Price->format($row, 'flat');
					$dateTemp[$key]['img'] = $this->Images->mainImage($row);
				}
			}
		}
		return $dateTemp;
    }

/**
 * TODO
 */
    
	private function _formatArray($data) {
		$dateTemp = array();
		foreach ($data as $key => $row) {
			if($row[$this->model]['active'] != '1') {
				unset($data[$key]);
			} else {
				$dateTemp[$key] = $row[$this->model];
				$dateTemp[$key]['link'] = $this->Seo->url($row[$this->model]);
				if(isset($dateTemp[$key]['price'])) {
					$dateTemp[$key]['price'] = $this->Price->format($row, 'flat');
				}
				if(isset($dateTemp[$key]['images'])) {
					$dateTemp[$key]['img'] = $this->Images->mainImage($row[$this->model]);
				}
			}
		} 
		return $dateTemp;
	}

}
?>