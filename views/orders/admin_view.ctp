<h1><?php echo $this->pageTitle = __('Order', true) . ' : ' . $data['Order']['number']; ?></h1>
<h2><?php __('Products'); ?></h2>
<?php if(!empty($data['LineItem'])) {
	echo $this->element('admin_table', array('data' => $data['LineItem'], 'model' => 'LineItem', 'addForm' => true));

 ?>
<?php } else { ?>
<p><?php __('No products'); ?></p>
<?php } ?>
<div class="section">
  <h2><?php __('Billing address'); ?></h2>
  <?php echo $hcard->addressFormatHtml($data['Order']) ?>
 </div>
<div class="section">
  <h2><?php __('Shipping address'); ?></h2>
  <?php echo $hcard->addressFormatHtml($data['Order'], '', 's_') ?>
</div>
<div class="section">
  <span class="shipping-method"><?php echo $data['Order']['shipping_method']; ?> <?php echo $price->currency($data['Order']['shipping_price']); ?></span>
  <span class="billing-method"><?php echo $data['Order']['payment_method']; ?> <?php echo $price->currency($data['Order']['payment_price']); ?></span>
    <?php if($data['Order']['state_tax'] > 0) { ?>
    <?php echo $price->currency($data['Order']['state_tax']); ?>
    <?php } ?>
</div>
<?php if(!empty($data['Order']['comments'])) { ?>
<div class="section" id="comments">
<h2><?php __('Comments')?></h2>
<?php echo $data['Order']['comments']; ?>
</div>
<?php } ?>
