<h1><?php echo $this->pageTitle = $this->data['Brand']['name']; ?></h1>
<?php echo $bs->adminLink(); ?>
<?php echo $this->element('products_by_brand', array('id' => $this->data['Brand']['id'], 'cache' => array('time' => '1 hour', 'key' => $this->data['Brand']['id']))); ?>
