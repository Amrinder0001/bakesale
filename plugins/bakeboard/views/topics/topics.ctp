<h1><?php echo $this->pageTitle = $this->data[0]['Topic']['title']; ?></h1>
<div id="topics">
  <?php 
  debug($this->data);
  foreach($this->data['Topic'] as $row) { ?>
  <div><?php echo $row['title']; ?></div>
    <?php } ?>
</div>