<?php

class ForumsController extends BakeboardAppController
{

/**
 * 
 */
 
	public function index() {
    $this->data = $this->Forum->getAllWithCounts();
	}

/**
 * 
 */
 
	public function show($id) {
    $this->data = $this->Forum->read(null, $id);
	}

/**
 * 
 */
 
	public function topics($id) {
    $this->data = ClassRegistry::init('Comments.Comments')->find('all');
	}

/**
 *
 */

	public function admin_add() {
        if(isset($this->data)) {
    	$this->_message($this->Forum->bsSave($this->data));
        }
    $this->render('admin_edit');
    }

/**
 *
 */

    public function admin_edit() {
        if(isset($this->data)) {
    	$this->_message($this->Forum->bsSave($this->data));
        }
    $this->data = $this->Forum->read(null, $id);
    }

/**
 * 
 */
 
	public function admin_index() {
    $this->data = $this->Forum->getAllWithCounts();
	}
}
?>