<?php
if(!isset($data)) {
	$data = $this->data;
} else {
	$this->data = $data;
}
$sort = array('contents', 'countries', 'shipping_methods', 'payment_methods');
$price = array('products', 'line_items');
$quantity = array('products', 'line_items');

	if(!isset($model)) {
    $model = false;
    $controller = $this->params['controller'];
	} else {
    if($model !== true) {
    } else {
    	$model = $this->params['models'][0];
    }
    $controller = Inflector::tableize($model);
	}
if(!empty($this->data)) {
	echo $form->create($model, array('action' => 'update_multiple')); 
?>
<table cellspacing="0" id="<?php echo $controller; ?>">
    <thead>
        <tr>
        	<?php if(in_array($controller, $sort)) { ?>
            <th class="sort"><?php __('Sort'); ?></th>
        	<?php } ?>
            <th class="name"><?php __('Name'); ?></th>
        	<?php if(in_array($controller, $price)) { ?>
            <th class="price"><?php __('Price'); ?></th>
            <?php } ?>
            <?php if($controller == 'products') { ?>
            <th class="special_price"><?php __('Special'); ?></th>
            <?php } ?>
            <?php if(in_array($controller, $quantity)) { ?>
            <th class="quantity"><?php __('Stock'); ?></th>
            <?php } ?>
           <?php if($controller == 'products') { ?>
           <th class="subproducts"><?php __('Subproducts'); ?></th>
            <?php } ?>
            <?php if($controller == 'payment_methods') { ?>
            <th class="proseccor"><?php __('Processor'); ?></th>
        	<?php } ?>
            <?php if($controller != 'line_items' && $controller != 'user_categories') { ?>
            <th class="active"><?php __('Active'); ?></th>
        	<?php } ?>
            <th class="actions"><?php __('Delete'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php 
    if($this->params['controller'] == 'brands') {
        $data = $data['Product'];
        $model = 'Product';
    }
    
    foreach ($data as $key => $row) { 
    	if(!isset($row['id'])) {
        $row = $row[$model];
    	}
    ?>
        <tr id="<?php echo $bs->rowId($row, $model);?>">
        	<?php if(in_array($controller, $sort)) { ?>
            <td class="sort"><?php echo $row['sort']; ?></td>
        	<?php } ?>
            <td><?php 
        echo $form->hidden($key . '.id', array('value' => $row['id']));
		$name = $bs->editLink($row, $model); 
        if($controller == 'line_items') {
        	$name = $row['name'];
        } 
		echo $name;
    	?></td>
        	<?php if(in_array($controller, $price)) { ?>
            <td class="price"><?php echo $form->input($key . '.price', array('value' => $row['price'])); ?></td>
            <?php } ?>
            <?php if($controller == 'products') { ?>
            <td class="special_price"><?php echo $form->input($key . '.special_price', array('value' => $row['special_price'])); ?></td>
             <?php } ?>
            <?php if(in_array($controller, $quantity)) { ?>
            <td class="quantity"><?php echo $form->input($key . '.quantity', array('value' => $row['quantity'])); ?></td>
             <?php } ?>
            <?php if($controller == 'products') { ?>
    	<?php
        if(!isset($row['Subproduct'])) {
        	$row['Subproduct'] = $data[$key]['Subproduct'];
        }
    	?>
            <td class="subproducts"><?php echo count($row['Subproduct']); ?></td>
            <?php } ?>
            <?php if($controller == 'payment_methods') { ?>
            <td class="proseccor"><?php echo $row['processor']; ?></td>
        	<?php } ?>
            <?php if($controller != 'line_items' && $controller != 'user_categories') { ?>
            <td class="active"><?php echo $bs->activateLink($row, $model);?></td>
        	<?php } ?>
            <td class="actions">
            <?php echo $form->checkbox($model . '.' . $key . '.delete'); ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<?php
	if($form) {
    	echo $form->end('Update');
	}
?>
<?php } else { ?>
<p><?php __('No ' . Inflector::humanize($controller)); ?></p>
<?php } ?>