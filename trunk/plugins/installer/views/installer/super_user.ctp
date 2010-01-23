<?php
echo $form->create('User', array('url' => array('controller' => 'installer', 'action' => 'super_user')));
echo $form->inputs(array(
'username' => array('label' => 'Email'), 
'password', 
)); 
echo $form->end('Save');
?>