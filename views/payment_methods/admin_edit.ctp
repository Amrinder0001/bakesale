<?php
$this->appendExternalCss('/css/2col-form.css');

echo $bs->pageHeader();
echo $form->create('PaymentMethod');
echo $form->inputs(array(
'legend' => __('Payment method', true),
'id', 'processor' => array('type' => 'hidden'), 'active', 'name', 'price', 'sort' => array('size' => '2')));
?>
<fieldset>
<legend><?php echo $this->data['PaymentMethod']['processor']; ?></legend>
<?php
foreach($processorData as $key => $value) {
	if($value == 'form' || $value == 'api') {
		echo $form->input('paymentConfig.' . $key, array('label' => Inflector::humanize($key), 'value' => $value, 'options' => array('form' => 'form', 'api' => 'api')));
	} else {
		echo $form->input('paymentConfig.' . $key, array('label' => Inflector::humanize($key), 'value' => $value));		
	}
}

echo $form->hidden('processor');
?>
</fieldset>
<?php echo $form->end('Save'); ?>