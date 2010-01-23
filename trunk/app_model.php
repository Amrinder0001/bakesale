<?php

/**
 * The parent class of all models in the application.
 */

class AppModel extends Model {

	public $customFinds = array('treepath'); 
	public $automaticDelete = array('Product', 'Category', 'Brand', 'ShippingMethod');
	public $cartSession = '';

/**
 * 
 */
 
	function beforeFind() {
		self::setCartSession();
	}

/**
 * 
 */
 
	function cleanEmpty() {
		if(in_array($this->name, $this->automaticDelete) && empty($this->id)) {
			$this->deleteAll(array($this->name . '.name' => ''), false, false); 
		}
	}
/**
 * get session id from controller
 */

	public function setCartSession() {
		if(!empty($_SESSION['Order']['session'])) {
			$this->cartSession = $_SESSION['Order']['session'];
		}
	}
/**
 */

	public function getFirstLetters($field = false) {
		if(!$field) {
			$field = $this->displayField;
		}
		$data = $this->query('select distinct(left(' . $field . ',1)) as Letter from ' . $this->tablePrefix . $this->table . ' order by ' . $field . ' ASC');
		 $array = Set::extract($data, '{n}.0.Letter'); 
		 $nuu = array();
		 foreach($array as $key => $row) {
		 	$nuu[$key] = strtoupper($row);
		 }
		 return $nuu;
	}

/**
 */

	public function getAlphabetConditions($firstLetter = false, $field = false) {
		if(!$field) {
			$field = $this->displayField;
		}
		$conditions = array();
		if($firstLetter) {
			$conditions = array($this->name . '.' . $field . ' LIKE' => $firstLetter . '%');
		} 
		return $conditions;
	}

/**
 */


	public function search($keywords) {
		return $this->name;
	}

/**
 * 
 */


	public function recursiveSelect() {
		return $this->generateTreeList(array(), '{n}.' . $this->name . '.id', '{n}.' . $this->name . '.name', '--', 4);
	}

/**
 * from http://othy.wordpress.com/2006/06/03/generatenestedlist/
 */

 
	public function generateNestedList($conditions = null, $indent = '--') {
		$cats = $this->findAllThreaded($conditions, array($this->name . '.id', $this->name . '.name', $this->name . '.parent_id'));
		return $this->_generateNestedList($cats, $indent);
	}

/**
 * from http://othy.wordpress.com/2006/06/03/generatenestedlist/
 */

	private function _generateNestedList($cats,$indent,$level = 0) {
		static $list = array();
		for($i = 0, $c = count($cats); $i < $c; $i++) {
			$list[$cats[$i][$this->name]['id']] = str_repeat($indent, $level) . $cats[$i][$this->name]['name'];
			if(isset($cats[$i]['children']) && !empty($cats[$i]['children'])) {
				$this->_generateNestedList($cats[$i]['children'], $indent, $level + 1);
			}
		}
		return $list;
	}

/**
 * Return menu
 */

    public function _menu($type = 'flat', $id = 0) {
		$conditions = array($this->name . '.parent_id' => $id);
		$recursive = -1;
		if(!strstr($type, 'admin')) {
			$conditions = array_merge($conditions, array($this->name . '.active' => '1'));
		}
		if(strstr($type, 'flat')) {
			$data = $this->find('all', array('conditions' => $conditions, 'recursive' => $recursive));
		} else {
			$data = $this->find('threaded', array('id', 'name', 'parent_id', 'active'));
		}
		return $data;
    }

/**
 * Universal add
 */


    public function bsAdd($data = array()) {
		$this->create();
		$this->data = $data;
		$this->save($this->data);
		return $this->getLastInsertID();
    }

/**
 * Universal add
 */

    public function bsSave($data = array(), $validate = true) {
		$this->data = $data;
		$itemName = '';
		if(!empty($this->data[$this->name][$this->displayField])) {
			$itemName = $this->data[$this->name][$this->displayField];
		} else if(!empty($this->data[$this->name]['id'])) {
			$itemName = $this->data[$this->name]['id'];
    }
    
    $name = Inflector::humanize($this->name);
    $result = array(
        'text' => 'Error saving ' . $name . ' %s',
        'url' => false,
        'name' => $itemName,
        'error' => true
    );
    if ($this->save($this->data, $validate)) {
    	$correctResult = array(
        'text' => $name . ' %s saved',
        'url' => 'previous',
        'error' => false,
    	);
    	$result = array_merge($result, $correctResult);
    }
    return $result;
    }

/**
 * Find all active
 */

    public function bsFindAllActive($recursive = -1, $conditions = array()) {
		$conditions = array_merge($conditions, array('active' => '1'));
		return $this->find('all', array('conditions' => $conditions, 'recursive' => $recursive));
    }

/**
 * Find all 
 */


    public function bsFindAll($recursive = -1, $conditions = array()) {
		return $this->find('all', array('conditions' => $conditions, 'recursive' => $recursive));
    }

/**
 * Find one 
 */


    public function bsFindOne($recursive = -1, $conditions = array()) {
		return $this->find('first', array('conditions' => $conditions, 'recursive' => $recursive));
    }

/**
 * Find one 
 */


    public function bsFindOneActive($recursive = -1, $conditions = array()) {
		$baseConditions = array('active' => '1');
		$conditions = array_merge($baseConditions, $conditions);
		return $this->find('first', array('conditions' => $conditions, 'recursive' => $recursive));
    }

/**
 * update multiple items
 */

    public function updateMultiple($data) {
		$this->data = $data;
		if (!empty($this->data)) {
			foreach($this->data[$this->name] as $key => $row) {
				if($row['delete'] == '1') {
					unset($this->data[$this->name][$key]);
					$deleteThese[$key] = $row['id'];
				}
			}
			if(isset($deleteThese)) {
				$this->deleteAll(array($this->name . '.id' => $deleteThese));
			}
			
			$message = __('Items saved', true);
			if (!empty($this->data[$this->name])) {
				if (!$this->saveAll($this->data[$this->name])) {
					$message = __('Items could not be saved', true);
				}
			}
			return $message;
		}
    }

/**
 * 
 */

    function find($type, $options = array()) {
        if (in_array($type, $this->customFinds)) {
            return $this->{'_find' . ucfirst($type)}($options);
        }
        return parent::find($type, $options);
    }

/**
 * 
 */

    function _findTreepath($options = array()) {
        // set some default options and get some from the parameters if set
        $pathField = 'tree_path';
        $labelField = 'name';
        if (isset($options['pathField'])) {
            $pathField = $options['pathField'];
            unset($options['pathField']);
        }
        if (isset($options['labelField'])) {
            $labelField = $options['labelField'];
            unset($options['labelField']);
        }
    
        // find the specified rows and return something like find('list') does
        $results = $this->find('all', $options);
        $return = array();
        foreach ($results as $i=>$result) {
            $this->_setTreePath($result, $pathField, $labelField);
            $return[$result[$this->name][$this->primaryKey]] = $result[$this->name][$pathField];
        }
        return $return;
    }

/**
 * 
 */
    
    function _setTreePath(&$data, $pathField, $label) {
        $cats = $this->getpath($data[$this->name][$this->primaryKey]);
        $path = array();
        foreach ($cats as $cat) {
            array_push($path, $cat[$this->name][$label]);
        }
        $data[$this->name][$pathField] = implode(' >> ', $path);
    } 

}

?>