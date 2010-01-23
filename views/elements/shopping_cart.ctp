<?php echo $form->create('LineItem', array('action' => 'edit_quantities')) ?>
<?php 
if($this->params['action'] == 'show') {
	$this->pageTitle = __('Shopping cart', true);
}
?>
<table cellspacing="0" class="cart" >
<!--  <caption>
  <?php //__('Shopping cart'); ?>
  </caption>-->
  <thead>
    <tr>
      <th><?php __('Product'); ?></th>
      <th><?php __('Price'); ?></th>
      <th><?php __('Total'); ?></th>
      <th><?php __('Quantity'); ?></th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <td class="total" colspan="4">
	  <?php 
    if($this->params['action'] != 'checkout') {
    	echo $this->element('total');
    }
    ?>
    <button type="submit">
    <?php __('Update'); ?>
        
        </button>
    </td>
    </tr>
  </tfoot>
  <tbody>
    <?php 
    $out_of_stock = false;
    foreach ($this->data['LineItem'] as $row) { 
    	$link = $html->url(array('controller' => 'products', 'action' => 'show', 'id'=> $row['Product']['id']));
    ?>
    <tr>
      <td><a href="<?php echo $link; ?>"> <?php echo $images->mainImage($row['Product'], false, 50, 50);?></a> <a href="<?php echo $link; ?>"><?php echo $row['Product']['name']; ?></a>
        <?php if (!empty($row['Subproduct']['name'])) { ?>
        ( <?php echo $row['Subproduct']['name']; ?> )
        <?php } ?>
        <?php  if ($row['out_of_stock']) { ?>
        <span class="error"><?php echo sprintf('Just %s available', $row['quantity_available']); ?></span>
        <?php } ?>
      </td>
      <td><?php echo $price->currency($row['price']); ?></td>
      <td class="total"><?php echo $price->currency($row['subtotal']); ?> </td>
      <td><?php echo $form->hidden('LineItem.' . $row['id'] . '.id', array('value' => $row['id'] )) ?> <?php echo $form->input('LineItem.' . $row['id'] . '.quantity', array('value' => $row['quantity'], 'label' => false)) ?> <?php echo $html->link(__('Remove', true), array('controller' => 'line_items', 'action' => 'delete', 'id' => $row['id'])); ?> </td>
    </tr>
    <?php } ?>
  </tbody>
</table>
</form>