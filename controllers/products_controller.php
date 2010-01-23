<?php

/**
 * BakeSale shopping cart
 * Copyright (c)	2006-2009, Matti Putkonen
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @author          Matti Putkonen,  matti.putkonen@fi3.fi
 * @copyright		Copyright (c) 2006-2009, Matti Putkonen
 * @link			http://bakesalepro.com/
 * @package			BakeSale
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 * @version $Id: products_controller.php 498 2007-08-06 16:19:11Z matti $
 */
 
class ProductsController extends AppController {
    public $uses = array('Product', 'Category', 'Brand');
    public $components = array('Search','Files');
    public $paginate = array('limit' => 15, 'page' => 1, 'order'=>array('Product.name'=>'asc')); 

/**
 * get search results
 */
	    
	public function search($keywords = '') {
		$searchFields = array('Product.name', 'Brand.name', 'Product.description');
		$data = $this->Search->query($this->Product, $keywords, $searchFields, ALL, ANYWHERE);
		return $data;
	}

/**
 * List products in admin
 */

	public function admin_index($firstLetter = false) {
        $firstLetters = $this->Product->getFirstLetters();
        $conditions = $this->Product->getAlphabetConditions($firstLetter);
        $this->data = $this->paginate('Product', $conditions);
        $this->set(compact('firstLetters'));
	}

/**
 * show product in shop
 * @param id int
 * The ID field of the product to show.
 */
    
	public function show($id) {
		$this->cacheAction = true; 
        $this->data = $this->Product->read(null, $id);
		$breadcrumbs = $this->validateProduct($this->data['Category']);
		if(!$breadcrumbs) {
			$this->redirect('/');
		}
		$this->set(compact('breadcrumbs'));
    }

/**
 * Validate product for root category if it is set
 */

	private function _validateProduct($data) {
        $root_category = Configure::read('Shop.root_category');
        if(empty($root_category) ) {
            return $this->Category->getpath($data[0]['id']);
        }
        $valid = false;
        foreach($data as $row) {
            $categoryPath = $this->Category->getpath($row['id']);
            if($categoryPath[0]['Category']['id'] == $root_category) {
                $valid = true;
            }
        }
        if($valid) {
            return $categoryPath;
        }
        return $valid;
    }

/**
 * show products by brand (MP: Move to Model ?)
 * @param id int
 * The ID field of the product to show.
 */
    
    function by_brand($brand_id) {
        $data = $this->Brand->find('first', 
            array(
                'conditions' => array(
                    'Brand.id' => $brand_id
                ),
                'recursive' => 2
            )
        );
        foreach($data['Product'] as $key => $row) {
            if(!$this->validateProduct($row['Category'])) {
                unset($data['Product'][$key]);
            }
        }
        return $data;
    }

/**
 * add new product
 */

    public function admin_add() {
        $this->instantAdd();
    }

/**
 * Add new image for product (MP: possibly pulled to app_controller for reuse ?)
 * @param $id int Product id
 */

    public function admin_add_image($id) {
        $this->viewPath = 'shared';
        $this->layout = 'ajax';
        $data = $this->Files->uploadSave($this->params['form']['imageFile'], $id, 'Product');
        $this->set(compact('data'));
    }

/**
 * Edit product
 * @param $id int Product id
 */

    public function admin_edit($id) {           
        parent::admin_edit($id);
        $brands = $this->Brand->find('list');
        $categories = $this->Category->find('treepath'); 
        $this->set(compact('brands', 'categories'));
    }

/**
 * get recent products
 * @param $limit
 */
  
    public function recent($limit = 20) {
		$order = 'Product.id DESC';
        $this->data = $this->Product->find('all', compact('limit', 'order'));
    }

}

?>