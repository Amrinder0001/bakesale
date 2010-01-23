<?php

/**
 * BakeSale shopping cart
 * Copyright (c)	2006-2009, Matti Putkonen
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright    Copyright (c) 2006-2009, Matti Putkonen
 * @link    	http://bakesalepro.com/
 * @package    	BakeSale
 * @license    	http://www.opensource.org/licenses/mit-license.php The MIT License
 * @version $Id: brand.php 508 2007-09-20 10:23:20Z matti $
 */

/**
 * brand.php
 *
 */

class Brand extends AppModel
{
    public $name = 'Brand';
	public $hasMany = array('LineItem', 'Product' =>
                       array('className'    => 'Product',
        	        'dependent'    =>  true));
	public $validate = array(
    'name' => array(
    	'unique' => array(
        'rule' => 'isUnique',  
        'message' => 'Name already used',
    	 ),
    	'notEmpty' => array(
            'required' => true,
        'rule' => 'notEmpty',  
        'message' => 'Name is required'
    	),  
    ),
	);
}
?>