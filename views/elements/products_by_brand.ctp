<?php 
echo $this->element('products', array(
'data' => $this->requestAction('/brands/products/' . $id))); 
?>
