<?php 
	$data = $this->requestAction('/categories/menu'); 
	if(isset($data)) {
?>
<ul id="categoriesmenu">
  <?php foreach ($data as $row){?>
  <li><?php echo $seo->link($row['Category'], 'categories'); ?></li>
  <?php } ?>
</ul>
<?php } ?>