<?php 
$model = $this->params['models'][0];
echo $form->create($model, array('action' => 'delete'));
echo $form->hidden('id', array('value' => $this->params['pass'][0]));
echo $form->end('Delete');
?>