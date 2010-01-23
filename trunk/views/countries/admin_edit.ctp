<?php
$this->appendExternalCss('/css/2col-form.css');

echo $bs->pageHeader();
echo $form->create('Country');
echo $form->inputs(array(
'legend' => __('Country', true),
'id', 'active', 
'name', 
'code' => array('size' => '2'), 'code3' => array('size' => '3'), 'sort' => array('size' => '2'),
));
?>
<fieldset>
<legend><?php __('Shipping methods')?></legend>
<?php echo $form->input('ShippingMethod.ShippingMethod', array('multiple' => 'checkbox')); ?>
</fieldset>
<?php
echo $form->end('Save');
?>
