<h1><?php echo $this->pageTitle = __('Order', true) . ' : ' . $this->data['Order']['number']; ?></h1>

<div class="section">
  <h2><?php __('Billing address'); ?></h2>
  <?php echo $hcard->addressFormatHtml($this->data['Order']) ?>
 </div>
<div class="section">
  <h2><?php __('Shipping address'); ?></h2>
  <?php echo $hcard->addressFormatHtml($this->data['Order'], '', 's_') ?>
</div>
<div class="section">
  <h2><?php __('Shipping method'); ?></h2>
  <span class="shipping-method"><?php echo $this->data['Order']['shipping_method']; ?> <?php echo $price->currency($this->data['Order']['shipping_price']); ?></span>
  <h2><?php __('Payment method'); ?></h2>
  <span class="billing-method"><?php echo $this->data['Order']['payment_method']; ?> <?php echo $price->currency($this->data['Order']['payment_price']); ?></span>
    <?php if($this->data['Order']['state_tax'] > 0) { ?>
    <?php echo $price->currency($this->data['Order']['state_tax']); ?>
    <?php } ?>
</div>
<?php if(!empty($this->data['Order']['comments'])) { ?>
<div class="section" id="comments">
<h2><?php __('Comments')?></h2>
<?php echo $this->data['Order']['comments']; ?>
</div>
<?php } ?>
<h2><?php __('Products'); ?></h2>
<?php if(!empty($this->data['LineItem'])) {
	echo $this->element('admin_table', array('data' => $this->data['LineItem'], 'model' => 'LineItem', 'addForm' => true));

 ?>
<?php } else { ?>
<p><?php __('No products'); ?></p>
<?php } ?>