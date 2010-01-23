<h1><?php echo $this->pageTitle = sprintf(__('Search results for: %s', true), $keywords); ?></h1>

<?php foreach ($this->data as $key => $row) { ?>
<h2><?php echo __($key); ?></h2>
<?php echo $this->element(Inflector::pluralize(strtolower($key)), array('data' => $this->data[$key])); ?>
<?php } ?>