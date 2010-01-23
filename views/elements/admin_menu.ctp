<div id="sbar">
<h2><?php __('Categories') ?></h2>
  <?php echo $tree->show('Category/name', $this->requestAction('/admin/categories/menu'), ' id="catlist" class="tree"', '/admin/categories/edit/'); ?>
<?php echo $bs->addLink('', 'categories'); ?> 
</div>
