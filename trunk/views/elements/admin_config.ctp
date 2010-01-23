<?php
if(!empty($data)) {
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
?>
<div class="add_stores" style="text-align:right; margin-bottom:5px">
<?php
    echo $html->link(__('Add storefront', true), array('controller' => $controller, 'action' => 'admin_add', 'id' => ""));
?>
</div>
<div id="list_stores">
<table cellspacing="0" id="<?php echo $controller; ?>">
    <thead>
        <tr>
            <th class="name"><?php __('Store'); ?></th>
            <th class="informations"><?php __('Main Infomations'); ?></th>
            <th class="actions"><?php __('Actions'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
    foreach ($data as $store => $row) {
    ?>
        <tr id="<?php __($store);?>">
            <td class="name"><?php __($store);?></td>
            <td class="informations">
                <table cellspacing=0>
                    <?php
                    foreach($row['info'] as $key => $val ) {
                    ?>
                    <tr>
                        <td><?php __($key);?></td>
                        <td><?php __($val);?></td>
                    </tr>
                    <?php } ?>
                </table>
            </td>
            <td class="actions" style="text-align:left">
                <?php
                echo $bs->editLink($row, $model);
                if($row['del']==true) {
                    echo " | " . $html->link(__('Delete', true), array('controller' => $controller, 'action' => 'admin_del', 'id' => $store), array('confirm' => 'Do you want to delete this config file?'));
                }
                ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
</div>
<?php } else { ?>
<p><?php __('No ' . Inflector::humanize($controller)); ?></p>
<?php } ?>