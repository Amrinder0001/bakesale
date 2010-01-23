<?php
$this->setBodyCssClass('simple-form');

echo $bs->pageHeader();
echo $form->create('PaymentMethod');
echo $form->inputs(array(
'legend' => __('Payment method', true),
'processor'
));
echo $form->end('Save');

?>