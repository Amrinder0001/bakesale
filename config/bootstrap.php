<?php
/* SVN FILE: $Id: bootstrap.php 502 2007-09-07 03:21:24Z matti $ */
/**
 * Short description for file.
 *
 * Long description for file
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework <http://www.cakephp.org/>
 * Copyright 2005-2007, Cake Software Foundation, Inc.
 *								1785 E. Sahara Avenue, Suite 490-204
 *								Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright		Copyright 2005-2007, Cake Software Foundation, Inc.
 * @link				http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package			cake
 * @subpackage		cake.app.config
 * @since			CakePHP(tm) v 0.10.8.2117
 * @version			$Revision: 502 $
 * @modifiedby		$LastChangedBy: matti $
 * @lastmodified	$Date: 2007-09-07 06:21:24 +0300 (pe, 07 syys 2007) $
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 *
 * This file is loaded automatically by the app/webroot/index.php file after the core bootstrap.php is loaded
 * This is an application wide file to load any function that is not used within a class define.
 * You can also use this to include or require any files in your application.
 *
 */
/**
 * The settings below can be used to set additional paths to models, views and controllers.
 * This is related to Ticket #470 (https://trac.cakephp.org/ticket/470)
 *
 * $modelPaths = array('full path to models', 'second full path to models', 'etc...');
 * $viewPaths = array('this path to views', 'second full path to views', 'etc...');
 * $controllerPaths = array('this path to controllers', 'second full path to controllers', 'etc...');
 *
 */
//EOF

define('IMAGES_UPLOAD_FOLDER', IMAGES_URL . 'uploads');
define('IMAGES_CACHE_FOLDER', IMAGES_URL . 'cache');

//match critera
define('ANYWHERE',0);
define('EXACT',1);
define('ENDS_WITH',2);
define('STARTS_WITH',3);
		
//mutikeyword criteria
define('ANY',0);
define('ALL',1);


function clean_num($num){
  return trim(trim($num, '0'), '.');
}

?>
