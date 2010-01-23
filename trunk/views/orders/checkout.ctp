<h1><?php echo $this->pageTitle = __('Checkout', true); ?></h1>
<?php 
echo $form->create('Order', array('action' => 'checkout'));
?>
<div id="form-wrapper">
<fieldset id="billing">
    <legend><?php __('Billing address'); ?></legend>
<?php 
foreach($billingFields as $row) {
	echo $form->input($row);
}
if (count($countries) > 1) {
	echo $form->input('country_id'); 
} else {
	echo $form->hidden('country_id', array('value' => $country['Country']['id']));
}
?>
</fieldset>
<?php if(Configure::read('Shop.seperate_addresses') == '1') { ?>
<fieldset id="shipping">
<legend><?php __('Shipping address'); ?></legend>
<div id="same-address">
<?php echo $form->checkbox('same', array('label' => false, 'div' => false)); ?>
<label><?php __('Same as billing address'); ?></label>
</div>
<?php
foreach($shippingFields as $row) {
	echo $form->input('s_' . $row, array('label' => __(ucfirst($row), true)));
}
if (count($countries) > 1) {
	echo $form->input('s_country_id', array('label' => __('Country', true), 'options' => $countries)); 
} else {
	echo $form->hidden('s_country_id', array('value' => $country['Country']['id']));
}
?>
</fieldset>
<div style="clear:both"></div>
<?php } else { 
echo $form->hidden('same', array('value' => '1'));
}
?>
<div class="handling">
<?php
if (!empty($paymentMethods)) {
	echo $bsform->generateHanlingChoices($paymentMethods, 'payment_method', $data['Order']['payment_method_id']);
} 

if (!empty($country['ShippingMethod'])) {
	echo $bsform->generateHanlingChoices($country['ShippingMethod'], 'shipping_method', $data['Order']['shipping_method_id']);
}
?>
</div>
<div style="clear:both"></div>
<div id="total">
<?php echo $this->element('total'); ?>
</div>
<div style="clear:both"></div>
<fieldset  id="Comments">
<legend><?php __('Comments'); ?></legend>
<?php echo $form->textarea('comments'); ?>
</fieldset>
<?php echo $form->hidden('session', array('value' => $session->read('Config.rand'))); ?>
</div>
<div style="clear:both"></div>
</form>
<?php echo $this->element('discount_code', array('plugin' => 'discount_codes')); ?>
<?php echo $this->element('shopping_cart')?>
