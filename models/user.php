<?php

/**
 * user.php
 *
 * @author Matti Putkonen,  matti.putkonen@fi3.fi
 * @copyright Copyright (c); 2006-2009, Matti Putkonen, Helsinki, Finland
 * @package BakeSale
 * @version $Id$
 */


class User extends AppModel {
    public $displayField = 'username';
    public $hasAndBelongsToMany = array('UserCategory');
	public $virtualFields = array(
    	'name' => 'CONCAT(User.username)'
	);

	public $validate = array(
    'username' => array(
    	'unique' => array(
			'rule' => 'isUnique',  
			'message' => 'Username already used',
    	 ),
    	'email' => array(
			'rule' => array('email'),  
				'message' => 'Not valid email'
			),  
			'notEmpty' => array(
			'rule' => 'notEmpty',  
			'message' => 'Username is required'
    	),  
    ),
	'password' => array(
		'firstRule' => array(
			'rule' => 'notEmpty',  
			'message' => 'Password is required',
			'on' => 'create',
		),
		)
	);

}
?>