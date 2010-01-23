<h1><?php echo $this->pageTitle = $this->data['Category']['name']; ?></h1>
<?php if(!empty($this->data['Category']['description'])) { ?>
<div class="catdesc"> <?php echo $description->out($this->data['Category']['description']); ?> </div>
<?php } ?>
<?php echo $bs->adminLink(); ?>
<?php echo $bs->adminLink(false, 'Product', 'add'); ?>
<?php echo $this->element('subcategories', array(
'plugin' => $this->data['Category']['id'], 'id' => $this->data['Category']['id'], 'cache' => '1 hour'))?>
<?php  echo $this->element('products_by_category', array('id' => $this->data['Category']['id'], 'cache' => array('time' => '1 hour', 'key' => $this->data['Category']['id']))); ?>
