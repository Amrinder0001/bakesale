<?php if($session->check('Message.auth.message')) { ?>
<div class="message"><?php echo $session->read('Message.auth.message'); ?></div>
<?php } ?>

<?php 
   echo $form->create('User', array('action' => 'login'));  
   echo $form->inputs(array('username', 'password', 'legend' => 'Login'));  
   echo $form->end('Login');  
?>