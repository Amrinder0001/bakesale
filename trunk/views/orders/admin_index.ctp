<?php
echo $bs->pageHeader();

if(!empty($this->data)) { 
		echo $form->create('Order', array('action' => 'update_multiple')); 
?>
<table cellspacing="0">
<?php if($this->params['action'] != 'admin_search') { ?>
  <thead>
    <tr>
      <th><?php echo $paginator->sort(__('Id', true), 'number');?></th>
      <th><?php echo $paginator->sort(__('Name', true), 'name');?></th>
      <th><?php __('Date'); ?></th>
      <th><?php __('Total'); ?></th>
      <th class="actions"><?php __('Actions'); ?></th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <td><?php echo $paginator->prev(); ?></td>
      <td colspan="3"><?php echo $paginator->numbers(); ?></td>
      <td><?php echo $paginator->next(); ?> </td>
    </tr>
  </tfoot>
  <?php } else { ?>
  <thead>
    <tr>
      <th><?php echo 'Id';?></th>
      <th><?php __('Name');?></th>
      <th><?php __('Date'); ?></th>
      <th><?php __('Total'); ?></th>
      <th class="actions"><?php __('Actions'); ?></th>
    </tr>
  </thead>
  <?php } ?>
  <tbody>
    <?php foreach ($this->data as $key => $row) { ?>
    <tr>
      <td><?php echo $row['Order']['number'] ?></td>
      <td><?php echo $bs->editLink($row['Order']);?></td>
      <td><?php echo $time->timeAgoInWords($row['Order']['created'],'n/j/y',false); ?></td>
      <td><?php echo $price->currency($row['Order']['total']); ?></td>
      <td class="actions"><?php echo  $form->hidden('Order.' . $key . '.id', array('value' => $row['Order']['id'])) . $form->checkbox('Order.' . $key . '.delete'); ?> </td>
    </tr>
    <?php } ?>
  </tbody>
</table>
<?php 
echo $form->end('Update');

} else {
?>
<p>
  <?php __('No orders'); ?>
</p>
<?php } ?>