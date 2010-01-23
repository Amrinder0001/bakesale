<h1><?php echo $this->pageTitle = __('Database import'); ?></h1>
<?php if (isset($errors) && !empty($errors)) {?>
<div id="errorMessage" class="message"><?php print_r($errors);?></div>
<?php } ?>
<?php
echo $form->create('Import', array('url' => array('controller' => 'installer', 'action' => 'import'))); 
echo $form->checkbox('demoproducts', array('label' => __('Import demo products ?')));
echo $form->end('Save');
?>