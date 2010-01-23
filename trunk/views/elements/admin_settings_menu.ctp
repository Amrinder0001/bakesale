<div id="sbar" class="settings">
<h2>Settings</h2>
  <ul>
    <li><a href="<?php echo $html->url(array('plugin' => '', 'controller' => 'shipping_methods')); ?>" class="shippingmethod"><?php __('Shipping methods') ?></a></li>
    <li><a href="<?php echo $html->url(array('plugin' => '', 'controller' => 'payment_methods')); ?>" class="paymentmethod"><?php __('Payment methods') ?></a></li>
    <li><a href="<?php echo $html->url(array('plugin' => '', 'controller' => 'countries')); ?>" class="country"><?php __('Countries') ?></a></li>
    <li><a href="<?php echo $html->url(array('plugin' => '', 'controller' => 'users', 'action' => 'index')); ?>" class="user"><?php __('Users') ?></a></li>
    <li><a href="<?php echo $html->url(array('plugin' => '', 'controller' => 'user_categories', 'action' => 'index')); ?>" class="usercategory"><?php __('User categories') ?></a></li>
    <li><a href="<?php echo $html->url(array('plugin' => '', 'controller' => 'contents', 'action' => 'index')); ?>" class="content"><?php __('Contents'); ?></a></li>
   <?php 
    $plugins = Configure::listObjects('plugin');
   	foreach($plugins as $row) {
       App::import('Controller', $row . '.' . $row . 'AppController');
       if(method_exists($row . 'AppController', 'getAdminMenuLink')) {
           $muikku = call_user_func(array($row . 'AppController', 'getAdminMenuLink'));
    	?> <li><a href="<?php echo $html->url($muikku); ?>" class="plugin"><?php echo __($row); ?></a></li><?php
       }
	  }
   ?>
   </ul>
</div>
