<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php __('en'); ?>" lang="<?php __('en'); ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo Configure::read('App.encoding'); ?>" />
<?php 
echo $this->getHeadContents();
flush();
echo $bs->adminMainLink($isAdmin);
$session->flash(); 
//echo $this->element('errors');
?>
<!-- start layout code -->
<div id="wrapper">
  <div id="header"><a href="<?php echo $html->url('/'); ?>" rel="home" id="logo"><?php echo Configure::read('Site.name') ?></a> <?php echo $this->element('search_form', array('plugin' => 'search')); ?> </div>
  <div id="subnav"><?php echo $this->element('categories', array('cache'=>'1 day')); ?></div>
  <div id="contentfloatholder">
    <div id="centerwrap">
      <div id="center">
	  <?php echo $this->element('breadcrumbs'); ?> 
	  <?php echo $content_for_layout; ?>
      </div>
    </div>
    <?php if($this->params['controller'] != 'orders') { ?>
    <div id="right"> <?php echo $this->element('minicart');?> </div>
    <div id="left"> <?php echo $this->element('brands', array('cache'=>'1 day')); ?> </div>
    <?php } ?>
  </div>
  <div id="footer"> <?php echo $this->element('contents', array('id' => 1, 'cache'=>'1 day')); ?>
    <p>Powered by <a href="http://bakesalepro.com/">BakeSale</a></p>
    <?php /*debug($_COOKIE);
    		debug($_SESSION);
    	debug($this->params);
		*/?>
  </div>
</div>
<!-- end layout code -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<?php 
	echo $this->getJs();
	echo $this->element('google_analytics');
?>
</body>
</html>
