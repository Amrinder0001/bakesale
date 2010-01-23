<?php 
if(!isset($extra)) {
	$extra = '';
}
if(isset($id)) {
	$data = $this->requestAction('contents/index/' . $id . '/' . $extra); 
}

if(!empty($data)) {
?>
<ul>
<?php foreach ($data as  $row) { 
if(empty($row['Content']['url'])) {
	$url = $seo->url($row['Content'], 'contents');
} else {
	$url = $row['Content']['url'];
}
?>
<li>
	<!--<a href="<?php //echo $url ?>"><?php //echo $row['Content']['name'] ?></a>-->
	<a href="<?php echo $html->url('/contents/show/' . $row['Content']['id']); ?>"><?php echo $row['Content']['name'] ?></a>
</li>
<?php } ?>
</ul>
<?php } ?>