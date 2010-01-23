<?php 
unset($data);
if(!isset($id)) {
	$id = '';
}
	$data = $this->requestAction('categories/menu/' . $id); 
	if(!empty($data)) {
?>
<ul class="categories cols">
  <?php foreach ($data as $row){
  	$url = $seo->url($row['Category'], 'categories')
  ?>
  <li>
  <a href="<?php echo $url; ?>"><?php echo $images->mainImage($row['Category']); ?></a>
  <a href="<?php echo $url; ?>"><?php echo $row['Category']['name']; ?></a>
  
  </li>
  <?php } ?>
</ul>
<?php } ?>