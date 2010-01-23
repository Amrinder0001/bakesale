<?php 
echo $bs->pageHeader(); 
echo $bs->addLink();

if(!empty($this->data)) {
	echo $form->create('User', array('action' => 'update_multiple')); 
?>

<table cellspacing="0">
  <tr>
    <th><?php echo __('Email'); ?></th>
    <th class="active"><?php __('Active'); ?></th>
    <th class="actions"><?php __('Delete'); ?></th>
  </tr>
  <tbody>
    <?php foreach ($this->data as $key => $row) { ?>
    <tr id="<?php echo $bs->rowId($row, 'User');?>">
      <td><?php 
        echo $form->hidden($key . '.id', array('value' => $row['User']['id']));
        echo $bs->editLink($row, 'User');        
    ?></td>
      <td class="active"><?php echo $bs->activateLink($row, 'User');?></td>
      <td class="actions"><?php echo $form->checkbox('User' . '.' . $key . '.delete'); ?> </td>
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
  <?php __('No ' . Inflector::humanize($controller)); ?>
</p>
<?php } ?>
