<?php 
$data = $this->requestAction('/orders/cart_contents/');
$total_item = 0;
if(isset($data['LineItem'])) {
	foreach ($data['LineItem'] as $row) { 
		$total_item += $row['quantity'];
	}
}	
?>
<ul class="link-t fr">
  <li class="ic-cart"><a href="<?php echo $html->url('/orders/show/'); ?>"><?php __('Shopping Cart:'); ?></a></li>
  <li><?php echo $total_item;?> <?php ($total_item > 1) ? __('item(s)') : __('item') ?> | </li>
  <li><a href="<?php echo $html->url(array('controller' => 'orders', 'action' => 'checkout')); ?>"><?php __('Checkout')?></a> | </li>
  <li><a href="#"><?php __('Customer Service') ?></a></li>
</ul>
