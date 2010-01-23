<h1><?php echo $this->pageTitle = $this->data['Topic']['name']; ?></h1>
<?php echo $this->data['Topic']['text']; ?>
<div id="topics">
  <?php foreach($this->data['Reply'] as $row) { ?>
  <div>
  <h2><?php echo $row['name']; ?></h2>
  <?php echo $row['text']; ?>
  </div>
    <?php } ?>
</div>