<?php if(!empty($this->data['LineItem'])) { ?>
<?php echo $this->element('shopping_cart')?>
<?php } else { ?>
<p><?php __('No products'); ?></p>
<?php } ?>
