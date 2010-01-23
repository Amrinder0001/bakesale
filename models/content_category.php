<?php

/**
 * content_category.php
 *
 * @author Matti Putkonen,  matti.putkonen@fi3.fi
 * @copyright Copyright (c); 2006-2009, Matti Putkonen, Helsinki, Finland
 * @package BakeSale
 * @version $Id: content_category.php 500 2007-08-25 15:16:53Z matti $
 */

class ContentCategory extends AppModel
{

    public $hasMany = array('Content' =>
                       array('className' => 'Content',
        	        'order'      => 'sort ASC'),
            	'SubContentCategory'=>
                          array('className' => 'ContentCategory',
                  'order'      => 'lft ASC',
                                'foreignKey' => 'parent_id',
                'dependent'    =>  true));
	public $actsAs = array('Tree');
    public $order = 'ContentCategory.lft ASC';
	
	public $validate = array(
    'name' => array(
    	'notEmpty' => array(
            'required' => true,
        'rule' => 'notEmpty',  
        'message' => 'Name is required'
    	),  
    ),
	);


}
?>