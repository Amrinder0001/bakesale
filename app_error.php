<?php

/**
 * from http://snook.ca/archives/cakephp/easier_static_pages_2/
 */

class AppError extends ErrorHandler {

/**
 * 
 */

	function __construct($method, $messages) {

		$params = Router::getParams();

		if (($method == 'missingController' || $method == 'missingAction') 
           && file_exists(VIEWS . DS . 'static' . DS . $params['controller'] . ".ctp")) {
			$this->controller =& new AppController();
			$this->controller->_set(Router::getPaths());
			$this->controller->params = $params;
			$this->controller->constructClasses();
			$this->controller->beforeFilter();
			$this->controller->viewPath = 'static';
			$this->controller->render($params['controller']);
			e($this->controller->output);
			exit;
		}

		parent::__construct($method, $messages);
		exit();
	}

}
?>
