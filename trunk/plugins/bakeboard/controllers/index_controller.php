<?php

class IndexController extends BakeboardAppController
{

	public $uses = array();
	
/**
 * 
 */
 
	public function index() {
    $this->set('forums', ClassRegistry::init('Bakeboard.Forum')->getAllWithCounts());  
    $this->set('topics', ClassRegistry::init('Topic')->find('all'));  
	}

}
?>