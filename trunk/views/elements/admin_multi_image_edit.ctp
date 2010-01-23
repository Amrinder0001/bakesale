<?php
if(empty($model)) {
	$model = $this->params['models'][0];
}
?>

  <div class="combined cbb" id="Image">
  	<h2><?php __('Images'); ?></h2>
    <?php 
	echo $bs->imageUpload($this->data[$model]['id']);    
	echo $images->adminImageList($this->data[$model]);
	?>
 </div>