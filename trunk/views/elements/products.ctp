<?php 
if(!empty($data)) {
$data = $bs->productArray($data);
 ?>
<ul class="products cols">
<?php foreach ($data as  $row) { ?>
<li class="hproduct"><a href="<?php echo $row['link']; ?>" rel="product"><?php echo $row['img']; ?></a>
<a href="<?php echo $row['link']; ?>" rel="product" class="name"><?php echo $row['name']; ?></a> 
<?php echo $row['price']; ?>
</li>
<?php } ?>
</ul>
<?php } ?>