<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php __('en'); ?>" lang="<?php __('en'); ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo Configure::read('App.encoding'); ?>" />
<?php 
echo $this->getHeadContents();
echo $bs->adminMainLink($isAdmin);
$session->flash(); 
?>
<!-- start layout code -->
<div id="wrapper" class="clearfix">
  <div id="header"> <a href="<?php echo $html->url('/'); ?>" rel="home" id="logo"><?php echo Configure::read('Site.name') ?></a>
    <!-- add layout code -->
    <?php echo $this->element('shopping_cart_top'); ?>
    <div id="subnav" class="fl">
      <div class="bg-t">
        <div class="bg-b"> <?php echo $this->element('categories', array('cache'=>'1 day')); ?>
          <form action="<?php echo $html->url('/search/'); ?>" method="get">
            <fieldset>
            <div class="fl search">
              <input name="keywords" id="keywords" type="text" value="Search..." onfocus="if (this.value == 'Search...') this.value = '';" onblur="if (this.value == '') this.value = 'Search...';"/>
            </div>
            <button type="submit"><img src="<?php echo $this->webroot .'img/button/go.png'; ?>" width="30" height="22" alt=""/></button>
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div id="contentfloatholder" class="clearfix">
    <?php //if($this->params['controller'] != 'orders') { ?>
    <div id="left" class="fl">
      <div class="menu-t">
        <div class="bg_lt"></div>
        <h4>browse categories</h4>
        <?php echo $this->element('brands', array('cache'=>'1 day')); ?>
        <ul class="bestseller">
          <li><a href="#"><span><?php __('Best Sellers') ?></span></a></li>
          <li><a href="#"><span><?php __('Gift Ideas') ?></span></a></li>
          <li><a href="#"><span><?php __('New Items') ?></span></a></li>
          <li><a href="#"><span><?php __('On Sale') ?></span></a></li>
        </ul>
        <div class="bg_lr"></div>
      </div>
      <?php echo $this->element('minicart');?> </div>
    <?php //} ?>
    <div id="center" class="fr"> <?php echo $this->element('breadcrumbs'); ?> <?php echo $content_for_layout; ?> </div>
    <?php if($this->params['controller'] != 'orders') { ?>
    <?php } ?>
  </div>
  <div id="footer" class="clearfix"> <?php echo $this->element('contents', array(
  								'plugin' => 'contents', 
								'id' => 1, 
								'cache'=>'1 day'
								)
							); ?>
    <p>&copy;  Copyright 2008 <a href="http://bakesalepro.com/">BakeSale</a>. All rights reserved.</p>
    <?php 
debug($_SESSION);
debug($this->params);
?>
  </div>
</div>
<!-- end layout code -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.1/jquery.min.js"></script>
<?php echo $this->getJs(); ?>
</body></html>
