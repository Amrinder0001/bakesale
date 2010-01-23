<?php
$this->appendExternalJs('/js/jquery.ocupload-1.1.2.packed.js');
?>
<?php echo $bs->pageHeader(true); ?>
<div id="page-content">
<?php
echo $form->create('Category');
echo $form->inputs(array('legend' => __('Category', true),
	'id', 'active', 'name', 
	'parent_id'  => array('empty' => true),
	'sort', 'description'));
echo $form->end('Save');	
?>
<div id="CategoryImage">
	<?php echo $images->mainImage($this->data['Category']);?>
    <?php echo $bs->imageUpload($this->data['Category']['id']);?> 
</div>
</div>
