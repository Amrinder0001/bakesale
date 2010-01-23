<?php 
$data = $this->requestAction('/contents/show/' . $id);
echo $description->out($data['Content']['description']);
?>