<?php

/**
 */

class  InstallerAppController extends AppController {
    public $components = array('Sql', 'Config');

	function beforeFilter() {
		$this->Auth->allow('*'); 
		Configure::write('Session.save', 'php'); 
		Configure::write('Cache.disable', true);
		Configure::write('Cache.check', false);
	}

	function beforeRender() {
		
	}

}