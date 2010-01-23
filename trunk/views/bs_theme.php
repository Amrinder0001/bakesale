<?php 

App::import('View', 'Theme');

class BsThemeView extends ThemeView {

	public $externalJs = array();
	public $headCss = array();
	public $bodyCssClass = array();
	public $pageTitle;

/**
 *
 */
 
	public function __construct (&$controller) {
        parent::__construct($controller);
		$this->schema = $this->params['controller'] . '-' . $this->params['action'];
		$this->themePath = WWW_ROOT . '/themed/';
    } 

/**
 * Output all header contents
 */

	public function getHeadContents() {	
		$headContent =  "\n";
		$headContent .= $this->_getPageTitle() . "\n";
		$headContent .= $this->_getExternalCssString();
		$headContent .= '</head>' . "\n";
		$headContent .= '<body class="' . $this->getBodyCssClass() . '">' . "\n";
		return $headContent;
	}

/**
 * Output all header contents
 */

	public function getJs() {	
		return $this->_getExternalJsString();
	}

/**
 * Get body css class as string 
 */

	public function getBodyCssClass() {
		$bodyCssClass = 'c-' . $this->params['controller'] . ' a-' . $this->params['action'];
		if(!empty($this->bodyCssClass)) {
			$bodyCssClass .= ' ' . trim(implode(' ', $this->bodyCssClass));
		}
		return str_replace('_', '-', $bodyCssClass);
	}

/**
 * Add new js file from view to the beginning of array
 */
 	public function appendExternalJs($jsFile) {
		$this->externalJs[] = $jsFile;
	}

/**
 * Add new css file from view to the beginning of array
 */

	public function appendExternalCss($cssFile) {
		$this->headCss[] = $cssFile;
	}

/**
 * Add new css file from view to the beginning of array
 */

	public function prependExternalCss($cssFile) {
		$this->headCss = array_merge(array($cssFile), $this->headCss);
	}

/**
 * Add new js file from view to the beginning of array
 */

	public function prependExternalJs($jsFile) {
		$this->externalJs = array_merge($this->externalJs, array($jsFile));
	}

/**
 * Add new class to html <body> element
 */

	public function setBodyCssClass($bodyCssClass) {
		$this->bodyCssClass = array_merge($this->bodyCssClass, array($bodyCssClass));
	}

/**
 * return full directory path to base view file
 */
 
	public function getBaseViewFile() {	
		return VIEWS . $this->params['controller'] . DS  . $this->params['action'] . '.ctp';
	}

/**
 * Get string of included Js files with html
 */
 
	private function _getExternalJsString() {	
		$jsFileArray = array_unique(array_merge($this->_getExternalJs(), $this->externalJs));
		$jsFileString = '';
		foreach($jsFileArray as $row) {
			$jsFileString .= '<script src="' . $this->getFileLocation($row) . '" type="text/javascript" ></script>' . "\n";
		}
		return $jsFileString;
	}

/**
 * Return location for external file.
 */
 
	private function getFileLocation($file, $filetype = 'js') {	
		$path =  Router::url('/');
		if(is_file(WWW_ROOT . 'themed' . DS . $this->theme . DS . $file)) {
			$path = $path . 'themed/' . $this->theme;
		}
		$fullPath = str_replace('//', '/', $path . $file);
		return Configure::read('SpeedOptimization.static_url') . $fullPath;
	}

/**
 * Get string of included CSS files with html
 */

	private function _getExternalCssString() {
		$cssFileArray = array_unique(array_merge($this->_getExternalCss(), $this->headCss));
		$cssFileString = '<style type="text/css">' . "\n";
		foreach($cssFileArray as $row) {
			$cssFileString .= '@import url("' . $this->getFileLocation($row) . '");' . "\n";
		}
		$cssFileString .= '</style>' . "\n";
		return $cssFileString;
	}


/**
 * Set page title. Use generated "Action controller" if none is set in the view
 */

	private function _setPageTitle() {
        $this->pageTitleStart = $this->_getPageTitleStart();
		if(!empty($this->pageTitle)) {
				$this->pageTitleStart = $this->pageTitle;    
		}
		$this->pageTitle = $this->pageTitleStart . ' : ' . Configure::read('Site.name') . Configure::read('Site.tagline');
	}

/**
 * generate pagetitle start from action and controller.
 */

	private function _getPageTitleStart() {
	    $title =  $this->params['controller'];
		$action = ltrim("admin_", $this->params['action']);
        return __(ucfirst(strtolower(Inflector::humanize($title))), true);
	}

/**
 * get page title with html
 */

	private function _getPageTitle() {
		$this->_setPageTitle();
        return '<title>' . $this->pageTitle . '</title>';
	}

/**
 *
 */

	private function _getExternalJs() {
		$automaticJs = array_merge($this->_getLayoutExternalFiles(), $this->_getViewExternalFiles());
		return array_merge($this->externalJs, $automaticJs);
	}

/**
 *
 */

	private function _getExternalCss() {
		$automaticCss = array_merge($this->_getLayoutExternalFiles('css'), $this->_getViewExternalFiles('css'));
		return array_merge($this->headCss, $automaticCss);
	}


/**
 *
 */

	private function _getLayoutExternalFiles($filetype = 'js') {
		$data = $this->_index($this->layout, $this->theme, $filetype);
		if(!empty($data)) {
			return array('combined/' . $this->layout. '/' . $this->theme . '.' . $filetype);
		}
		return array();
	}

/**
 *
 */

	private function _getViewExternalFiles($filetype = 'js') {
		$data = $this->_index($this->schema, $this->theme, $filetype);
		if(!empty($data)) {
			return array('combined/' . $this->schema . '/' . $this->theme . '.' . $filetype);
		}
		return array();
	}

/**
 * Create javascript or CSS files
  */
    
	private function _index($schema, $theme, $filetype) {
		if(strstr($schema, '.')) {
			$files = $this->_getPluginFileInfo($filetype, $schema, $theme);
		} else {
			$files = $this->_getBaseFileInfo($filetype, $schema, $theme);
		}
		$all = array_merge($files['basefiles'], $files['themefiles']);
		$all = array_unique($all);
		return $this->_generateFileArray($all, $files['basepath'], $files['themepath']);
    }

/**
 * Get file info array for plugin files
 */

	private function _getPluginFileInfo($filetype, $schema, $theme) {
		$data = array();
		if(strstr($schema, '.')) {
			$schemaArray = explode(".", $schema);
			$schema = $schemaArray[1];
			$data['basepath'] = APP . 'plugins' . DS . $schemaArray[0] . DS . 'webroot' . DS .  $filetype . DS;
			$data['themepath'] = $data['basepath'] . $theme . DS;
		} else {
			$data['basepath'] = WWW_ROOT . $filetype . DS;
			$data['themepath'] = VIEWS . $this->themePath . DS . $filetype . DS;
		}
		$data['basefiles'] = $this->_findFiles($data['basepath'], $schema, $filetype);
		$data['themefiles'] = $this->_findFiles($data['themepath'], $schema, $filetype);
		return $data;
	}

/**
 * Get file info array for base files
 */

	private function _getBaseFileInfo($filetype, $schema) {
		$data = array();
		$data['basepath'] = WWW_ROOT . $filetype . DS;
		$data['themepath'] = WWW_ROOT . $this->themePath . DS . $filetype . DS;
		$data['basefiles'] = $this->_findFiles($data['basepath'], $schema, $filetype);
		$data['themefiles'] = $this->_findFiles($data['themepath'], $schema, $filetype);
		return $data;
	}

/**
 * get list of files from a directory
 */

	private function _generateFileArray($all, $basepath, $themepath) {
		$data = array();
		foreach ($all as $key => $row) {
			$data[$key]['file'] = $row;
			$data[$key]['path'] = $basepath;
			if(is_file($themepath . $row)) {
			$data[$key]['path'] = $themepath;
			}
		}
		return 	$data;	
	}


/**
 * Get list of files from a directory
 */

	private function _findFiles($path, $schema, $filetype) {
		$base = new Folder($path);
		return $base->find($schema . '(.*).' . $filetype);
	}

}

?>