<?php 
$this->appendExternalJs('/js/shared/jquery.form.js');
$this->appendExternalCss('/css/shipping-methods.admin-edit.css');
$this->appendExternalJs('/js/jquery.asmselect.js');
$this->appendExternalCss('/css/jquery.asmselect.css');
?>

<?php echo $bs->pageHeader(); ?>
<div class="combined" id="ShippingMethod">
<?php
echo $form->create('ShippingMethod');
echo $form->inputs(array(
'legend' => __('Shipping method', true),
'id', 'active', 'name', 'price', 'sort'));
echo $form->inputs(array('fieldset'=>'countries', 'Country.Country'));
echo $form->end('Save'); 
?>
</div>

<div class="combined" id="ShippingRule">
<?php
echo $form->create('ShippingRule', array('class' => 'instant'));
echo $form->inputs(array(
	'legend' => __('Add shipping rule', true),
	'type', 'min', 'max', 'price',
	'shipping_method_id'  => array('value' => $this->data['ShippingMethod']['id'], 'type' => 'hidden'),
)); 
echo $form->end('Save');
?>
<?php echo $form->Create('ShippingRule', array('action' => 'update_multiple'));  ?>
<table cellspacing="0">
	<thead>
  <tr>
    <th><?php __('Type'); ?></th>
    <th><?php __('Min'); ?></th>
    <th><?php __('Max'); ?></th>
    <th><?php __('Price'); ?></th>
    <th><?php __('Delete'); ?></th>
  </tr>
  </thead>
  <tbody>
<?php if(!empty($this->data['ShippingRule'])) { ?>
    <?php foreach($this->data['ShippingRule'] as $key => $row) { ?>
    <tr>
      <td>
	  <?php echo $form->input('type', array('div' => false))?> </td>
      <?php $fields = array('min', 'max', 'price');?>
      <?php foreach($fields as $row2) {?>
      <td>
	  <?php echo $form->input($key . '.' . $row2, array('value' => $row[$row2], 'div' => false))?>
	  </td>
      <?php } ?>
 <td class="actions"><?php echo $html->link(__('Delete', true), array('controller' => 'shipping_rules', 'action' => 'delete', $row['id']), array('class' => 'delete')); ?><?php echo $form->input($key . '.id', array('value' => $row['id'])); ?></td>    </tr>
    <?php } ?>
<?php } ?>
</table>
<?php echo $form->end('Update'); ?>
</div>