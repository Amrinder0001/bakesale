<?php 
$this->setBodyCssClass('simple-form');

echo $bs->pageHeader(); 
echo $form->create('ShippingMethod');
echo $form->inputs(array(
'legend' => __('Shipping method', true),
'active', 'name'
));
echo $form->end('Save');
?>