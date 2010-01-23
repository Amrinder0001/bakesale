<h1><?php echo $this->pageTitle = __('Installer'); ?></h1>
<?php if(!empty($errors)) {  ?>
<?php foreach ($errors as $row) {  ?>
<div class="error">
  <p><?php echo $row['message'] ?></p>
  <p><?php echo $row['solution'] ?></p>
</div>
<?php } ?>
<?php echo $html->link(__('Try again', true), array()); ?>
<?php } ?>
