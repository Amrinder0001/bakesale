<?php

/**
 * shipping_rule.php
 *
 * @author Matti Putkonen,  matti.putkonen@fi3.fi
 * @copyright Copyright (c); 2006-2009, Matti Putkonen, Helsinki, Finland
 * @package BakeSale
 * @version $Id: shipping_rule.php 246 2006-12-24 13:55:42Z matti $
 */

class ShippingRule extends AppModel
{
	public $belongsTo = 'ShippingMethod';
}
?>
