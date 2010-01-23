<?php 
$this->sidebar = 'admin_brands_menu';
if(!empty($this->data['Brand'])) {
	echo $bs->pageHeader();
	echo $bs->link();
	echo $bs->link('delete'); 
	echo $this->element('admin_table', array('model' => 'Product'));
}
?>