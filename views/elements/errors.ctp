<?php 
$data = $this->requestAction('/errors/check/');
if(!empty($data)) { ?>
<div class="error">
<dl>
<?php foreach($data as $row) { ?>
<dt><?php echo $row['message']; ?></dt>
<dd><?php echo $row['solution']; ?></dd>
<?php } ?>
</dl>
</div>
<?php } ?>