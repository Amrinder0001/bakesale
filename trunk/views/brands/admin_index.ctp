<?php 

echo $bs->pageHeader();
if(!empty($this->data)) {
	echo $form->create('Brand', array('action' => 'update_multiple')); 
?>
<table class="Brands">
  <tr>
    <th><?php echo $paginator->sort('Name', 'name'); ?></th>
    <th class="active"><?php echo $paginator->sort('Active', 'active'); ?></th>
    <th class="actions"><?php __('Delete'); ?></th>
  </tr>
  <tfoot>
    <td colspan="3"><?php
	echo $paginator->prev('? Previous ', null, null, array('class' => 'disabled'));
	echo $paginator->numbers();
	echo $paginator->next(' Next ?', null, null, array('class' => 'disabled'));
?>
    </td>
    </tfoot>
  <tbody>
    <?php foreach ($this->data as $key => $row) { ?>
    <tr id="<?php echo $bs->rowId($row, 'Brand');?>">
      <td><?php 
        echo $form->hidden($key . '.id', array('value' => $row['Brand']['id']));
        echo $html->link($row['Brand']['name'], array('action' => 'edit', 'id' => $row['Brand']['id']), array('escape' => false));
    	?></td>
      <td class="active"><?php echo $bs->activateLink($row, 'Brand');?></td>
      <td class="actions"><?php echo $form->checkbox('Brand' . '.' . $key . '.delete'); ?> </td>
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
<?php } ?>