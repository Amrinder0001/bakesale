<?php

class SitemapsController extends SitemapsAppController
{

	public $helpers = array('Seo', 'Time');
	public $uses = null;

/*
 * get content for sitemap and render
 */

	public function index() {
    $this->layout = 'ajax';
    $this->RequestHandler->respondAs('xml');
    $this->set('data', $this->getSiteMapData());
	}

/*
 * Get data for site map
 */

	public function getSiteMapData() {
    $models = array('Brand', 'Product', 'Category', 'Content');
    	
    foreach($models as $key => $row) {
    	$this->$row = ClassRegistry::init($row); 
    	$this->$row->recursive = -1;
    	$data[$key] = $this->$row->findAll($row . '.active = 1');
    }
    return $data;
	}

/*
 * show finished page
 */

	public function admin_info() {
    $bodyClass = 'col2l';
    $sidebar = 'admin_settings_menu';
    $sitemapUrl = FULL_BASE_URL . DS . 'sitemap.xml';
    $this->set(compact('sitemapUrl', 'bodyClass', 'sidebar'));
	}


}
?>