<?php

$config['Site'] = array(
	'version' => '1.3.0',
	'name' => 'BakeSale',
	'tagline' => '- simply shopping cart',
	'email' => 'matti.putkonen@fi3.fi',
	'admin_access' => array('matti.putkonen@fi3.fi'),
	'theme' => 'plain',
	'locale' => 'en',
	'https_url' => '',
	'google_analytics' => '',
);

$config['Shop'] = array(
	'stock_control' => '1',
	'on_soldout' => 'active',
	'minimum_order' => '0',
	'seperate_addresses' => '1',
	'root_category' => '',
);

$config['Localization'] = array(
	'address_format' => 'US',
);


$config['Currency'] = array(
	'code' => 'USD',
	'symbol_left' => '$',
	'symbol_right' => '',
	'decimal_digits' => '2',
	'thousands_point' => ',',
	'decimal_point' => '.',
);

$config['Image'] = array(
	'thumb_height' => '100',
	'thumb_width' => '100'
);

$config['State'] = array(
	'code' => 'AL',
	'tax' => '0.1',
);
$config['SpeedOptimization'] = array(
	'static_url' => '',
);
