<div class="delete">
    <h1><?php __('Delete brand :'); ?> "<?php echo $data['Brand']['name']; ?>"</h1>
   <?php echo $form->create('Brand', array('action' => 'delete')) ?>
    <?php echo $form->hidden('name'); ?>
        <?php echo $form->hidden('id'); ?>
    <input type="checkbox" name="data[Brand][cascade]" /><?php __('Delete products ?')?>
        <button type="submit"><?php __('Delete'); ?></button>
    </form>
</div>
