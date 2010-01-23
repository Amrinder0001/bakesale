<?php
$this->setBodyCssClass('simple-form');

echo $bs->pageHeader();
echo $form->create('UserCategory');
echo $form->inputs(array('id', 'name')); 
echo $form->end('Save');
?>