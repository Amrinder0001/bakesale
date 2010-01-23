<?php 
$this->prependExternalCss('/css/full-index.css');
echo $bs->pageHeader(); 
echo $this->element('alphabet_pagination', compact('firstLetters'));
if(!empty($this->data)) {
	echo $form->create('Product', array('action' => 'update_multiple')); 
?>

<table class="products">
  <tr>
    <th><?php echo $paginator->sort('Name', 'name'); ?></th>
    <th class="brand"><?php echo $paginator->sort('Brand', 'Brand.name'); ?></th>
    <th class="price"><?php echo $paginator->sort('Price', 'price'); ?></th>
    <th class="quantity"><?php echo $paginator->sort('Stock', 'quantity'); ?></th>
    <th class="active"><?php __('Active'); ?></th>
    <th class="actions"><?php __('Delete'); ?></th>
  </tr>
  <tfoot>
  <td colspan="2"><?php echo $paginator->numbers(); ?></td>
    <td colspan="2"><?php
	echo $paginator->prev('< Previous ', null, null, array('class' => 'disabled'));
	echo $paginator->next(' Next >', null, null, array('class' => 'disabled'));
?>
    </td>
    <td colspan="2"><?php echo $paginator->counter(); ?></td>
    </tfoot>
  <tbody>
    <?php 
    
    foreach ($this->data as $key => $row) { 
    ?>
    <tr id="<?php echo $bs->rowId($row, 'Product');?>">
      <td><?php 
        echo $form->hidden($key . '.id', array('value' => $row['Product']['id']));
        echo $html->link(
        $images->mainImage($row['Product'], false, 50, 50) .  
        ' ' . $row['Product']['name'], array('action' => 'edit', 'id' => $row['Product']['id']), array('escape' => false));
    	?></td>
      <td class="brand"><?php echo $row['Brand']['name']; ?></td>
      <td class="price"><?php echo $form->input($key . '.price', array('value' => $row['Product']['price'])); ?></td>
      <td class="quantity"><?php echo $form->input($key . '.quantity', array('value' => $row['Product']['quantity'])); ?></td>
      <td class="active"><?php echo $bs->activateLink($row, 'Product');?></td>
      <td class="actions"><?php echo $form->checkbox('Product' . '.' . $key . '.delete'); ?> </td>
    </tr>
    <?php } ?>
  </tbody>
</table>
<?php
	if($form) {
    echo $form->end('Update');
	}
?>
<?php } else { ?>
<p>
  <?php __('No ' . Inflector::humanize($this->params['controller'])); ?>
</p>
<?php } ?><br><br>
