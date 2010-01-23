<?php 
if($hasCart) {
$data = $this->requestAction('/orders/cart_contents/');
if(!empty($data['LineItem'])) {

$cartClass = '';
if (isset($this->params['named']['cart'])) {
	$cartClass = ' class="blink"';
}
echo $session->read('CartMesssage');
?>
<div id="box-cart">
<div class="ct_cart"><img src="<?php echo $this->webroot .'img/0.gif'; ?>" width="0" height="2" alt=""/></div>	
	<div id="cart"<?php echo $cartClass; ?>>
    <h2><a href="<?php echo $html->url('/orders/show/'); ?>">
    	<?php __('Shopping cart'); ?>
    	</a></h2>
    <ul>
    	<?php foreach ($data['LineItem'] as $row) { 
    	//debug($row);
    	?>
    	<li class="product"><span><?php echo $row['quantity']; ?> x 
    	<a href="<?php echo $html->url('/products/show/' . $row['Product']['id']); ?>"><?php echo $row['Product']['name']; ?></a></span>
    	<?php if(!empty($row['Subproduct'])) { ?>
    	<span class="subproduct"><?php echo $row['Subproduct']['name']; ?></span>
    	<?php } ?>
    	</li>
    	<?php } ?>
    </ul>
    <ul class="total">
    	<li>
        <?php __('Subtotal'); ?>
        <?php echo $price->currency($data['Order']['subtotal']); ?></li>
    	<?php if($data['Order']['discount'] > 0) { ?>
    	<li>
        <?php __('Discount'); ?>
        <?php echo $price->currency($data['Order']['discount']); ?></li>
    	<?php } ?>
    	<li>
        <?php __('Shipping'); ?>
        <?php echo $price->currency($data['Order']['shipping_price']); ?> </li>
    	<li>
        <?php __('Payment'); ?>
        <?php echo $price->currency($data['Order']['payment_price']); ?> </li>

    	<li class="total">
        <?php __('Total'); ?>
        <?php echo $price->currency($data['Order']['total']); ?></li>
    </ul>
    <?php if($data['Order']['subtotal'] >= Configure::read('Shop.minimum_order')) {?>
    <p align="center">
    <a class="checkout2"  href="<?php echo $html->url(array('controller' => 'orders', 'action' => 'checkout')); ?>">
    <?php //__('Checkout'); ?>Check out</a>
    </p>
    <?php } else { ?>
    <p class="error"><?php echo __('Minimum order') . ' : ' . Configure::read('Shop.minimum_order') ?></p>
    <?php } ?>
	</div>
<div class="cb_cart"><img src="<?php echo $this->webroot .'img/0.gif'; ?>" width="0" height="2" alt=""/></div>
</div>
<?php } 
} ?>
