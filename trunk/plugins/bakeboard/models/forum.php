<?php

class Forum extends BakeboardAppModel {
    public $hasMany = array('Topic'=>
                          array('order'      => 'created ASC',
                'dependent'    =>  true));


/**
 * Return all forums with topic and reply counts
 */
 
	public function getAllWithCounts() {
    $data = $this->find('all');
    $data = self::getTopicCounts($data);
    $data = self::getReplyCounts($data);
    return $data;
	}

/**
 * Add post count to forum array
 */

	public function getTopicCounts($data) {
    foreach($data as $key => $row) {
    	$data[$key]['Forum']['topicCount'] = $this->Topic->find('count', array('conditions' => array('forum_id' => $data[$key]['Forum']['id'], 'parent_id' => 0)));
    }
    return $data;
	}

/**
 * Add reply count to forum array
 */

	public function getReplyCounts($data) {
    foreach($data as $key => $row) {
    	$data[$key]['Forum']['replyCount'] = $this->Topic->find('count', array('conditions' => array('forum_id' => $data[$key]['Forum']['id'], 'parent_id' => 0)));
    }
    return $data;
	}

}

?>