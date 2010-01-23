<?php if($this->data['Product']['cart'] != '0') { ?>
<?php echo $form->create('LineItem', array('action' => 'add')); ?>
<fieldset>
<?php 
echo $form->hidden('LineItem.product_id', array('value' => $this->data['Product']['id'])); 
echo $form->hidden('LineItem.quantity', array('value' => '1'));
echo $bsform->subproducts($this->data);
echo $form->button(__('Add to cart', true));
?>
</fieldset>
</form>
<?php } ?>
