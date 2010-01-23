<?php

class Topic extends BakeboardAppModel {
	public $belongsTo = array('Forum');
    public $hasMany = array('Reply'=>
                          array('className' => 'Topic',
                  'order'      => 'created',
                                'foreignKey' => 'parent_id',
                'dependent'    =>  true));
}

?>