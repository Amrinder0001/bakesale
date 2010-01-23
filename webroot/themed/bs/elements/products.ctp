<?php 
if(!empty($data)) {
$data = $bs->productArray($data);
if(empty($_REQUEST['url']))
{
?>
<div class="fl mr-b10">
<a href="#"><img src="img/banner/bn_largrtop.jpg" width="683" height="227" alt="" /></a>
<ul>
	<li><a href="#"><img src="img/banner/bn_small1.jpg" width="224" height="112" alt="" /></a></li>
	<li><a href="#"><img src="img/banner/bn_small2.jpg" width="227" height="112" alt="" /></a></li>
	<li><a href="#"><img src="img/banner/bn_small3.jpg" width="224" height="112" alt=""/></a></li>
</ul>
</div>
<?php } ?>
<?php  if(isset($data['Content']['name'])) { ?>
	<h1><?php echo $this->pageTitle = $data['Content']['name']; ?>featured items</h1>
<?php } ?>
<ul class="products cols">
<?php foreach ($data as  $row) { ?>
<li><p class="box-img"><a href="<?php echo $row['link']; ?>"><?php echo $row['img']; ?></a>
<a href="<?php echo $row['link']; ?>"><?php echo $row['name']; ?></a> 
<?php echo $row['price']; ?></p>
</li>
<?php } ?>
</ul>
<?php } ?>