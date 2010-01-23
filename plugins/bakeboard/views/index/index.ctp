<h1><?php echo $this->pageTitle = __('Forum', true); ?></h1>
<h2>
  <?php __('Categories'); ?>
</h2>
<?php
echo $this->element('forum_list', array('data' => $forums)); 
?>
<h2><?php __('Recent activity'); ?></h2>
<div id="topics">
  <?php foreach($topics as $row) { ?>
  <div><?php echo $row['Topic']['name']; ?></div>
    <?php } ?>
</div>