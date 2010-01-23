<?php

echo $bs->pageHeader();
$fields = array('id', 'username');
if($this->params['action'] != 'edit') {
	$fields = array_merge($fields, array('password'));
}
echo $form->create('User');
echo $form->inputs($fields); 
if($this->params['action'] != 'add') {
	echo $form->inputs(array('firstname', 'lastname', 'email', 'phone', 'address', 'postcode', 'city',
	'state_id',
	'country_id',
	));
}
echo $form->end('Save');
?>