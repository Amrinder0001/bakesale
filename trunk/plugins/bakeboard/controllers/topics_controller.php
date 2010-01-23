<?php

class TopicsController extends BakeboardAppController
{

/**
 * 
 */
 
	public function show($id) {
    $this->data = $this->Topic->find('first');
	}

}
?>