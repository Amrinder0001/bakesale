<?php 
unset($data);
$data = $this->requestAction('/categories/products/' . $id);
if(!empty($data)) {
	echo $this->element('products', array('data' => $data)); 
} 
?>
