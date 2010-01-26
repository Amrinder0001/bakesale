<?php
$javascript->link(array(
	'shared/jquery.asmselect',
	'shared/jquery.form',
	'shared/jquery.ocupload-1.1.2.packed',
	'products/admin-edit',

), false);
$this->appendExternalCss('/css/jquery.asmselect.css');
$this->appendExternalCss('/css/products/admin-edit.css');

?>
<div class="combined" id="product">
<div class="page-header">
<?php echo $bs->pageHeader(true);?>
</div>
<?php
echo $form->create('Product');
echo $form->inputs(array('id', 'name', 'description')); 
echo $form->inputs(array('fieldset'=>'categories', 'Category.Category', 'brand_id' => array('empty' => true)));
echo $form->inputs(array('fieldset'=>'numeric', 'active', 'cart', 'price', 'special_price', 'weight', 'quantity'));
echo $form->end(__('Save product', true)); 
?>
</div>
  
  
  
  
  <div class="combined" id="images">
  	<h2><?php __('Images'); ?></h2>
    <?php 
	echo $bs->imageUpload($this->data['Product']['id']);    
	echo $images->adminImageList($this->data['Product']);
	?>
 </div>
 
 
 
  <div class="combined" id="subproducts"> 
  <h2><?php __('Subproducts'); ?></h2>
  <?php 
		echo $form->create('Subproduct', array('action' => 'add', 'class' => 'instant')); 
		echo $form->inputs(array(
			'legend' => __('Add subproduct', true), 
			'product_id' => array('value' => $this->data['Product']['id'], 'type' => 'hidden'), 
			'name', 
			'price' => array('value' => '0'), 
			'weight' => array('value' => '0'), 
			'quantity' => array('value' => '0')));
		echo $form->end('Add subproduct');
	?>
    <?php echo $form->Create('Subproduct', array('action' => 'update_multiple'));  ?>
    <table>
    <thead>
      <tr>
        <th><?php __('Sort'); ?></th>
        <th><?php __('Name'); ?></th>
        <th><?php __('Price'); ?></th>
        <th><?php __('Weight'); ?></th>
        <th><?php __('Stock'); ?></th>
        <th><?php __('Delete'); ?></th>
      </tr>
      </thead>
      <tbody>
        <?php if(!empty($this->data['Subproduct'])) { ?>
        <?php foreach($this->data['Subproduct'] as $key => $row) {?>
        <tr id="subproduct-<?php echo $row['id']; ?>">
          <td class="sort"><?php echo $form->input($key . '.id', array('value' => $row['id'])); ?></td>
          <?php $fields = array('name', 'price', 'weight', 'quantity');?>
          <?php foreach($fields as $row2) {?>
          <td class="<?php echo $row2 ?>"><?php echo $form->input($key . '.' . $row2, array('value' => $row[$row2])); ?></td>
          <?php } ?>
          <td class="actions"><?php echo $html->link(__('Delete', true), array('controller' => 'subproducts', 'action' => 'delete', $row['id']), array('class' => 'delete')); ?></td>
        </tr>
        <?php } ?>
        <?php } ?>
        </tbody>
    </table>
<?php echo $form->end(__('Update subproducts', true)); ?>
  </div>