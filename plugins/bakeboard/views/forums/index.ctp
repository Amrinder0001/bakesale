<h1>Forums</h1>
<?php 
echo $html->link('Add forum', array('action' => 'add')); 
echo $this->element('forum_list'); 
?>