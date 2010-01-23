<h1><?php echo $this->pageTitle = __('Database settings'); ?></h1>

<?php if (isset($errors) && !empty($errors)) { ?>
<div id="errorMessage" class="message"><?php print_r($errors);?></div>
<?php } ?>

<?php

echo $form->create('Database', array('url' => '/installer/installer/database/')); 
echo $form->inputs(array(
'legend' => $this->pageTitle,
'database_name',
'database_user',
'database_password',
));
echo $form->inputs(array(
'legend' => __('Advanced settings', true),
'database_server' => array('value' => 'localhost'),
'table_prefix'
));
echo $form->end('Save');
?>