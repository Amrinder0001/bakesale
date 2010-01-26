<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php __('en'); ?>" lang="<?php __('en'); ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo Configure::read('App.encoding'); ?>" />
<?php echo $this->getHeadContents(); ?>
<div id="nonFooter">
<?php $session->flash(); ?>
<div class="header">
 <?php echo $this->element('admin_header', array('cache'=>'1 day')); ?>
</div>
<?php flush(); ?>
<div id="wrapper">
<?php  
if(isset($this->sidebar)) { 
	if(is_array($this->sidebar)) {
    echo $this->element($this->sidebar[0], array('plugin' => $this->sidebar[1]));
	} else {
    echo $this->element($this->sidebar);
	}
}
?>
  <div id="content"><?php echo $content_for_layout; ?> </div>
</div>
</div>
<div id="footer">
  <p>Powered by <a href="http://bakesalepro.com/">BakeSale</a></p>
</div>
<?php
	debug($_SESSION);
	debug($this->params);	
?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<?php echo $scripts_for_layout ?>
<?php echo $this->getJs(); ?>
</body></html>
