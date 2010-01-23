<?php
$this->appendExternalJs('/js/silverstripe.tree.js');
?>
<div id="sbar">
<h2><?php __('Content categories'); ?></h2>
<?php 
echo $tree->show(
	'ContentCategory/name',
	$this->requestAction('/admin/content_categories/menu'),
	' id="catlist" class="tree"',
	'/admin/contents/index/');
?>
<?php echo $html->link('Add content category', array('controller' => 'content_categories', 'action' => 'add'), array('class' => 'add')); ?>
</div>
