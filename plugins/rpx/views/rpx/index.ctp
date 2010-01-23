<h1><?php echo $this->pageTitle = __('Login', true); ?></h1>
<?php
$tokenUrl = FULL_BASE_URL . $html->url();
	if(isset($this->data)) {
	   debug($this->data);
?>
<a href="<?php echo $tokenUrl ?>"><?php __('Logout'); ?></a>
<?php } else { ?>
<iframe src="https://<?php echo $siteName; ?>.rpxnow.com/openid/embed?token_url=<?php echo urlencode($tokenUrl); ?>" scrolling="no" frameBorder="no" style="width:400px;height:240px;">
</iframe>
<?php } ?>