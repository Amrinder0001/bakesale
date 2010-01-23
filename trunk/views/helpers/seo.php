<?php

/**
 * SEO helper to create new, fine URLs that Google loves.
 *
 * @author Matti Putkonen,  matti.putkonen@fi3.fi
 * @copyright Copyright (c); 2006-2009, Matti Putkonen, Helsinki, Finland
 * @package BakeSale
 * @version $Id: seo.php 512 2007-10-05 07:12:41Z matti $
 */

    class SeoHelper extends Helper {
		public $helpers = array('Html');

/**
 * generate SEO link
 *
 * @param $data
 * @param $controller
 * @param $action
 */

	public function link($data, $controller = 'products', $action = 'show', $plugin = '') {
		$url = $this->url($data, $controller, $action, $plugin);
		$link = '<a href="' . $url . '"><span>' . $data['name'] . '</span></a>';    
		return $link;
	}

/**
 * generate SEO url
 *
 * @param $data
 * @param $controller
 * @param $action
 */

	public function url($data, $controller = 'products', $action = 'show', $plugin = '') {
		$myvar = low(Inflector::slug($data['name'], '-'));
	
		$myvar = '/' . $myvar;
		$link = $this->Html->url(array_merge(compact('plugin', 'myvar', 'controller', 'action'), array($data['id'])));
		/*
		$splitter = Router::url('/');
		$linkArray = explode($splitter, $link);
		unset($linkArray[0]);
		$linkText = implode('/', $linkArray);
		return Router::url('/') . low(Inflector::slug($linkText, '-')) . '.html';
		*/
		return $link;
	}

}
?>