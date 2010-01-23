<?php
$this->appendExternalCss('/css/simple-form-wide.css');

echo $bs->pageHeader();
echo $form->create('ContentCategory');
echo $form->inputs(array('legend' => __('Content category', true),
	'id', 'active', 'name',
	'description'  => array('rows' => '12', 'cols' => '60'),
	'parent_id' => array('empty' => true)
));
echo $form->end('Save');
?>
