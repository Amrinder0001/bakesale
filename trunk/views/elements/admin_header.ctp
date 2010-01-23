<ul class="menu">
  <li><?php echo $bs->tLink('Products', array('plugin' => '', 'controller' => 'products', 'action' => 'index')); ?>
    <ul>
      <li><?php echo $bs->tLink('Products', array('plugin' => '', 'controller' => 'products', 'action' => 'index')); ?></li>
      <li><?php echo $bs->tLink('Add product', array('plugin' => '', 'controller' => 'products', 'action' => 'add')); ?></li>
      <li><?php echo $bs->tLink('Categories', array('plugin' => '', 'controller' => 'categories', 'action' => 'index')); ?></li>
      <li><?php echo $bs->tLink('Add category', array('plugin' => '', 'controller' => 'categories', 'action' => 'add')); ?></li>
      <li><?php echo $bs->tLink('Brands', array('plugin' => '', 'controller' => 'brands', 'action' => 'index')); ?></li>
      <li><?php echo $bs->tLink('Add brand', array('plugin' => '', 'controller' => 'brands', 'action' => 'add')); ?></li>
    </ul>
  </li>
  <li><?php echo $bs->tLink('Orders', array('plugin' => '', 'controller' => 'orders', 'action' => 'index')); ?></li>
  <li><?php echo $bs->tLink('Settings', array('plugin' => '', 'controller' => 'payment_methods', 'action' => 'index')); ?>
    <ul>
    <li><?php echo $bs->tLink('Shipping methods', array('plugin' => '', 'controller' => 'shipping_methods')); ?></li>
    <li><?php echo $bs->tLink('Payment methods', array('plugin' => '', 'controller' => 'payment_methods')); ?></li>
    <li><?php echo $bs->tLink('Countries', array('plugin' => '', 'controller' => 'countries')); ?></li>
    <li><?php echo $bs->tLink('Users', array('plugin' => '', 'controller' => 'users', 'action' => 'index')); ?></li>
    <li><?php echo $bs->tLink('User categories', array('plugin' => '', 'controller' => 'user_categories', 'action' => 'index')); ?></li>
    <li><?php echo $bs->tLink('Contents', array('plugin' => '', 'controller' => 'contents', 'action' => 'index')); ?></li>
   <?php 
    $plugins = Configure::listObjects('plugin');
   	foreach($plugins as $row) {
       App::import('Controller', $row . '.' . $row . 'AppController');
       if(method_exists($row . 'AppController', 'getAdminMenuLink')) {
           $muikku = call_user_func(array($row . 'AppController', 'getAdminMenuLink'));
    	?> 
            <li><?php echo $bs->tLink($row, $muikku); ?></li>
    	<?php
       }
	  }
   ?>
   </ul>

  
  </li>
</ul>  
<a href="<?php echo $html->url(array('plugin' => '', 'controller' => 'users', 'action' => 'logout', 'admin' => false)); ?>" class="logout"><?php __('Logout'); ?></a>
<a href="<?php echo $html->url('/'); ?>" class="shop"><?php __('Shop'); ?></a>