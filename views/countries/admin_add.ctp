<?php echo $bs->pageHeader(); ?>
<ul>
<?php foreach($this->data as $key => $row) { ?>
	<li><a href="<?php echo $html->url(array('action'=> 'add', 'id' => $key));?>"><?php echo $row[0] ?></a></li>
<?php } ?>
</ul>