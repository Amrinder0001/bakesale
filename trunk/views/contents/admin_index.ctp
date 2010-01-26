<?php 
$this->setBodyCssClass('with-sidebar');
$this->sidebar = 'admin_contents_menu';
$this->appendExternalCss('/css/shared/silverstripe.tree.css');
$javascript->link('shared/silverstripe.tree', false);

if(!empty($this->data)) { 
	echo $bs->pageHeader();
	echo $bs->addLink();
	echo $this->element('admin_table', array('model' => true));
}
?>