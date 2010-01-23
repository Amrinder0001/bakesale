<?php
/* SVN FILE: $Id: routes.php 4410 2007-02-02 13:31:21Z phpnut $ */
/**
 * Short description for file.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
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
 * @since			CakePHP(tm) v 0.2.9
 * @version			$Revision: 4410 $
 * @modifiedby		$LastChangedBy: phpnut $
 * @lastmodified	$Date: 2007-02-02 07:31:21 -0600 (Fri, 02 Feb 2007) $
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 */

	Router::connect('/combined/*', array('controller' => 'combined', 'action' => 'index'));
	
	Router::connect('/search/*', array('plugin' => 'search', 'controller' => 'search', 'action' => 'index'));

	Router::connect('/login/*', array('controller' => 'pages', 'action' => 'login'));

	Router::connect('/sitemap.xml', array('plugin' => 'sitemaps', 'controller' => 'sitemaps', 'action' => 'index'));

	Router::connect('/robots.txt', array('controller' => 'pages', 'action' => 'robots'));


	Router::connect('/admin', array( 'controller' => 'products', 'action' =>
'index', 'admin' => 1 , 'prefix' => 'admin'));

// SEO setting for brands
Router::connect('/:myvar/b/*',
	array('myvar' => null, 'controller' => 'brands', 'action' => 'show'),
	array('myvar' => '.*')
);
/*
Router::connect(
	'/:slug-b-:id.html',
	array('controller' => 'brands', 'action' => 'show'),
	array(
		'pass' => array('id', 'slug'),
		'slug' => '.*',
		'id' => '[\d]+'
	)
);
*/
// SEO setting for categories
Router::connect('/:myvar/c/*',
	array('myvar' => null, 'controller' => 'categories', 'action' => 'show'),
	array('myvar' => '.*')
);
/*
Router::connect(
	'/:slug-c-:id.html',
	array('controller' => 'categories', 'action' => 'show'),
	array(
		'pass' => array('id', 'slug'),
		'slug' => '.*',
		'id' => '[\d]+'
	)
);
*/


// SEO setting for products
Router::connect('/:myvar/p/*',
	array('myvar' => null, 'controller' => 'products', 'action' => 'show'),
	array('myvar' => '.*')
);
/*
Router::connect(
	'/:slug-p-:id.html',
	array('controller' => 'products', 'action' => 'show'),
	array(
		'pass' => array('id', 'slug'),
		'slug' => '.*',
		'id' => '[\d]+'
	)
);
*/
	
// SEO setting for contents

Router::connect('/:myvar/con/*',
	array('myvar' => null, 'plugin' => 'contents', 'controller' => 'contents', 'action' => 'show'),
	array('myvar' => '.*')
);
/*
Router::connect(
	'/:slug-con-:id.html',
	array('plugin' => 'contents', 'controller' => 'contents', 'action' => 'show'),
	array(
		'pass' => array('id', 'slug'),
		'slug' => '.*',
		'id' => '[\d]+'
	)
);
*/

// SEO setting for content categories
Router::connect('/:myvar/ccon/*',
	array('myvar' => null, 'controller' => 'content_categories', 'action' => 'show'),
	array('myvar' => '.*')
);
/*
Router::connect(
	'/:slug-ccon-:id.html',
	array('controller' => 'content_categories', 'action' => 'show'),
	array(
		'pass' => array('id', 'slug'),
		'slug' => '.*',
		'id' => '[\d]+'
	)
);

*/
//RSS feeds
	Router::parseExtensions('rss');
	
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.thtml)...
 */
	Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
/**
 * Then we connect url '/test' to our test controller. This is helpfull in
 * developement.
 */
	Router::connect('/tests', array('controller' => 'tests', 'action' => 'index'));
?>