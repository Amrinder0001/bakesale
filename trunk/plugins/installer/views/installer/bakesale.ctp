<h1><?php echo $this->pageTitle = __('BakeSale settings'); ?></h1>
<?php if (isset($errors) && !empty($errors)) {?>
<div id="errorMessage" class="message"><?php print_r($errors);?></div>
<?php } ?>

<?php
Configure::load('base_config');
$site = Configure::read('Site');

echo $form->create(null, array('url' => '/installer/installer/bakesale/')); 
echo $form->inputs(array(
'legend' => __('Site settings'),
'Site.version' => array('value' => $site['version'], 'disabled' => 'disabled', 'size' => '4'),
'Site.name' => array('value' => $site['name']),
'Site.tagline' => array('value' => $site['tagline']),
'Site.email' => array('value' => $site['email']),
'Site.theme', 
'Site.locale',
'Site.https_url',
'Site.google_analytics',
));

echo $form->inputs(array(
'legend' => __('Shop settings'),
'Shop.stock_control' =>  array('type' => 'checkbox'),
'Shop.on_soldout' => array('options' => array('active', 'cart')),
'Shop.minimum_order' => array('class' => 'numeric', 'size' => '4'),
'Shop.seperate_addresses' => array('type' => 'checkbox'),
'Shop.verify_order_automatically' => array('type' => 'checkbox'),
'Shop.root_category' => array('type' => 'hidden', 'value' => ''),
));


$currency = Configure::read('Currency');
echo $form->inputs(array(
'legend' => __('Currency settings'),
'Currency.code' => array('size' => '4', 'value' => $currency['code']),
'Currency.symbol_left' => array('size' => '5', 'value' => $currency['symbol_left']),
'Currency.symbol_right' => array('size' => '5', 'value' => $currency['symbol_right']),
'Currency.decimal_digits' => array('class' => 'numeric', 'size' => '1', 'value' => $currency['decimal_digits']),
'Currency.thousands_point' => array('size' => '1', 'value' => $currency['thousands_point']),
'Currency.decimal_point' => array('size' => '1', 'value' => $currency['decimal_point']),
));

$image = Configure::read('Image');
echo $form->inputs(array(
'legend' => __('Image settings'),
'Image.thumb_height' => array('class' => 'numeric', 'size' => '4', 'value' => $image['thumb_height']),
'Image.thumb_width' => array('class' => 'numeric', 'size' => '4', 'value' => $image['thumb_width']),
));

echo $form->inputs(array(
'legend' => __('State settings'),
'State.code' => array('size' => '2'),
'State.tax' => array('size' => '5'),
));

echo $form->end('Save');
?>