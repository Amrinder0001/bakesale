    <form action="<?php echo $html->url(array('plugin' => 'search', 'controller' => 'search', 'action' => 'index')); ?>" method="get">
      <fieldset>
      <label for="keywords"><?php __('Search'); ?></label>
      <input name="keywords" id="keywords" type="text" />
      <button type="submit"><?php __('Search'); ?></button>
      </fieldset>
    </form>
