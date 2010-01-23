<?php 
$this->setBodyCssClass('with-sidebar');
$this->sidebar = 'admin_contents_menu';

if(!empty($this->data)) { 
	echo $bs->pageHeader();
	echo $bs->addLink();
	echo $this->renderElement('admin_table', array('model' => true));
}
?>
