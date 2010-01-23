<?php

echo $bs->pageHeader(true);
echo $form->create('Content');
echo $form->inputs(array(
'legend' => __('Content', true),
'id', 'active', 'name', 'url', 'sort', 'content_category_id', 'description')); 
echo $form->end('Save');

?>


  <div class="combined cbb" id="Image">
  	<h2><?php __('Images'); ?></h2>
    <?php 
	echo $bs->imageUpload($this->data['Content']['id']);    
	echo $images->adminImageList($this->data['Content']);
	?>
 </div>