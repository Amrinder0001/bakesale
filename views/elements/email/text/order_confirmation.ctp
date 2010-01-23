<?php 
$seperator = '------------------------------------------------------' . "\n";
echo Configure::read('Site.name') . "\n"; ?>
<?php echo $seperator; ?>
<?php echo __('Order number', true) .  ' : ' . $data['Order']['number'] . "\n" .
	__('Order date', true) .  ' : ' . $data['Order']['created'] . "\n" .
	__('Email', true) .  ' : ' . $data['Order']['email'] . "\n" .
	__('Phone', true) .  ' : ' . $data['Order']['phone'] . "\n" .

	$data['Order']['comments'] . "\n\n"; ?>
<?php echo __('Products') .  "\n"; ?>
<?php echo $seperator; ?>
<?php foreach ($data['LineItem'] as $row) {
    echo $row['quantity'] . ' x ' . $row['product'] . ' ' . $row['subproduct']  . '  ' . $price->currency(($row['quantity'] * $row['price']), 'email') . "\n";
	}
?>
<?php echo $seperator; ?>
<?php echo	__('Subtotal') .  ' ' . $price->currency($data['Order']['subtotal'], 'email') .  "\n"; ?>
<?php echo	$data['Order']['shipping_method'] . ' ' . $price->currency($data['Order']['shipping_price'], 'email') .  "\n"; ?>
<?php echo	$data['Order']['payment_method'] . ' ' . $price->currency($data['Order']['payment_price'], 'email') .  "\n"; ?>
<?php
if($data['Order']['tax'] > 0) {
	__('State tax') .  ' ' . $price->currency($data['Order']['tax'], 'email') .   "\n";
}
?>
<?php echo __('Total') .  ' ' . $price->currency($data['Order']['total'], 'email'); ?>
<?php  echo "\n\n\n"; ?>
<?php 
if(!Configure::read('Shop.seperate_addresses') == '1') {
	echo __('Address') .  "\n";
	echo $seperator;
	echo $hcard->addressFormatRaw($data['Order']);
} else {
	echo __('Billing address') .  "\n";
	echo $seperator;
	echo $hcard->addressFormatRaw($data['Order']);
	echo "\n\n";
	echo __('Shipping address') .  "\n";
	echo $seperator;
	echo $hcard->addressFormatRaw($data['Order'], '', 's_');

}
?>
<?php //debug($data)?>