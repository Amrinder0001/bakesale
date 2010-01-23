
<ul class="total">
    <li id="bsubtotal"><?php __('Subtotal'); ?>
        <span><?php echo $price->currency($data['Order']['subtotal']); ?></span></li>
	<?php if($data['Order']['discount'] > 0) { ?>
	<li>
    <?php __('Discount'); ?>
    <?php echo $price->currency($data['Order']['discount']); ?></li>
	<li>
	<?php } ?>
    
	<li id="bshipping"><?php __('Shipping'); ?>
        <span><?php echo $price->currency($data['Order']['shipping_price']); ?></span> </li>
	<li id="bshipping"><?php __('Payment'); ?>
        <span><?php echo $price->currency($data['Order']['payment_price']); ?></span> </li>

    <li id="btotal"><?php __('Total'); ?>
        <span><?php echo $price->currency($data['Order']['total']); ?></span></li>
</ul>
    <?php if($data['Order']['subtotal'] >= Configure::read('Shop.minimum_order')) {?>
    <?php if( $this->params['action'] == 'show') { ?>
    <a href="<?php echo $html->url(array('controller' => 'orders', 'action' => 'checkout')); ?>" class="checkout"><?php __('Checkout'); ?></a>
    <?php } else { ?>
        <button type="submit"><?php __('Confirm order'); ?></button>
    <?php } ?>
    <?php } else { ?>
    <p class="error"><?php echo __('Minimum order') . ' : ' . Configure::read('Shop.minimum_order') ?></p>
    <?php } ?>