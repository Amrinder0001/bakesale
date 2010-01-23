<?php 
echo $form->create(array('controller' => 'pages', 'action' => 'login'));
echo $form->inputs(array('username', 'password' => array('type' => 'password'), 'legend' => __('Login', true)));
echo $form->end('Login');
?>