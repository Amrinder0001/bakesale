<?php

/**
 * BakeSale shopping cart
 * Copyright (c)	2007, Matti Putkonen
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @author Matti Putkonen,  matti.putkonen@fi3.fi
 * @copyright    Copyright (c) 2007, Matti Putkonen
 * @link    	http://bakesalehq.com/
 * @package    	BakeSale
 * @license    	http://www.opensource.org/licenses/mit-license.php The MIT License
 * @version $Id$
 */
uses('Sanitize'); 	

class SearchController extends SearchAppController
{

	public $components = array('Search');
	public $uses = array();
	public $paginate = array('limit' => 100, 'page' => 1); 

	public $searchModels = array('Product');

/**
 * Search results page
 */

    public function index() {
    $keywords = $this->_cleanKeywords($this->params['url']);
    $this->data = $this->_searchResult($keywords);
    $this->set(compact('keywords'));
    }

/**
 * clean keywords string
 */

    private function _cleanKeywords($data) {
    $keywords = $data['keywords'];
    if(!empty($keywords)) {
    	$san = new Sanitize();
    	$keywords = $san->html($keywords);
    } else {
    	$keywords = '';
    }
    return $keywords;
    }

/**
 *
 */

    private function _searchResult($keywords) {
    foreach($this->searchModels as $row) {
    	$data[$row] = $this->query($keywords, array('Product.name'));
    }
    return $data;
    }

/*
 * Build search conditions
 */
	
    public function query($keywords, $searchFields, $multipleKeywords = 0, $matchType = 0, $fields = '*', $limit = 50, $page = 1, $order = false)
    {    
    //$conditions = array($searchFields . ' LIKE' => '%' . $keywords . '%');
     
    $modelName = explode('.', $searchFields[0]);
    
        $conditions = "(";
        
        $keywords = explode(' ', $keywords);
        $keyCount = count($keywords);
        
        for($k = 0; $k < $keyCount; $k++)
        {
    	debug($conditions);

    	for($i=0; $i < count($searchFields); $i++)
    	{
        $searchField = $searchFields[$i];
        $conditions .= "$searchField LIKE '%$keywords[$k]%'";   
        
        if ($i < count($searchFields)-1 )
        {
        	$conditions .= " OR ";
            }
        
        }

        if ($k < $keyCount-1 )
    	{
        
        switch ($multipleKeywords) 
        {
        case ANY:
        	$conditions .= ") OR (";
        	break;
        case ALL:
        	$conditions .= ") AND ("; 
        	break;
        }
        }
        else
        {
            $conditions .= ')';
        }
        }
    $model->recursive = 1;
    $extra = '';
    if($modelName[0] != 'Order') {
    	$extra = ' and ' . $modelName[0] . '.active = 1';
    }
    //return $conditions;
    $model = ClassRegistry::init($modelName[0]); 
    return $model->findAll($conditions . $extra, $fields, $order, $limit, $page);
	}

}

?>