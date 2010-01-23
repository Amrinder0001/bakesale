<?php

/**
 * category.php
 *
 * @author Matti Putkonen,  matti.putkonen@fi3.fi
 * @copyright Copyright (c); 2006-2009, Matti Putkonen, Helsinki, Finland
 * @package BakeSale
 * @version $Id: category.php 451 2007-06-15 08:01:35Z matti $
 */

class Category extends AppModel
{

	public $hasAndBelongsToMany = array('Product' =>
                       array('className' => 'Product'));
    public $hasMany = array('SubCategory'=>
                          array('className' => 'Category',
                  'order'      => 'lft',
                                'foreignKey' => 'parent_id',
                'dependent'    =>  true));
	public $actsAs = array('Tree'); 

	public $validate = array(
		'name' => array(
			'notEmpty' => array(
				'required' => true,
				'rule' => 'notEmpty',  
				'message' => 'Name is required',
				'on' => 'edit'
			),  
		),
	);


/**
 * if using storefronts check that the root category is correct.
 */

    public function isValidCategory($id) {
		$root_category = Configure::read('Shop.root_category');
		$valid = true;
		if(!empty($root_category) ) {
			$valid = false;
			$categoryPath = $this->getpath((int)$id);
			if($categoryPath[0]['Category']['id'] ==  $root_category) {
			$valid = true;
			}
		}
		return $valid;
    }

}
?>