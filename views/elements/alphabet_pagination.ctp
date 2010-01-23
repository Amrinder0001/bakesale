<?php if(!empty($firstLetters)) { ?>
<div class="alphabet-pagination">
<?php foreach($firstLetters as $row) { ?>
<?php echo $html->link($row, array('id' => $row)); ?>
<?php } ?>
<?php echo $html->link(__('Show all', true), array()); ?>
</div>
<?php } ?>