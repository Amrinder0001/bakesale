<?php
$this->setBodyCssClass('simple-form');

echo $bs->pageHeader(true);
echo $form->create('Brand');
echo $form->inputs(array('id', 'active', 'name')); 
echo $form->end('Save');
?>
