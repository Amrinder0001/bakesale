<?php
	echo $bs->pageHeader();
	echo $bs->addLink();
	//echo $this->element('admin_table', array('model' => true, 'editForm' => false));
	echo $adminTable->out();
?>
