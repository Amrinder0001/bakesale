<?php

class UserCategory extends AppModel {

    public $hasAndBelongsToMany = array('User');

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