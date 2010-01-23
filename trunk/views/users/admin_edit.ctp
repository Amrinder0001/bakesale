<?php
$this->setBodyCssClass('simple-form');

echo $bs->pageHeader();
$fields = array('id', 'active', 'username', 'UserCategory.UserCategory');
if($this->params['action'] != 'admin_edit') {
	$fields = array_merge($fields, array('password'));
}
echo $form->create('User');
echo $form->inputs($fields); 
echo $form->inputs(array('firstname', 'lastname', 'email', 'phone', 'address', 'postcode', 'city',
'state_id',
'country_id',
));

echo $form->end('Save');
?>