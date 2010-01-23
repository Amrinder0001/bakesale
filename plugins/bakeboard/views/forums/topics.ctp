<h1><?php echo $this->pageTitle = $this->data[0]['Topic']['title']; ?></h1>
<?php 
echo $this->element('listing', array('plugin' => 'comments')); 
?>
<div id="topics">
  <?php foreach($this->data['Topic'] as $row) { ?>
  <div><?php echo $row['title']; ?></div>
    <?php } ?>
</div>