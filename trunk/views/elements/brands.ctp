<?php 
	$data = $this->requestAction('/brands/menu'); 
	if(isset($data)) {
?>
<ul id="brands">
    <?php foreach ($data as $row) { ?>
	<li><?php echo $seo->link($row['Brand'], 'brands'); ?></li>
	<?php } ?>
</ul>
<?php } ?>