<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Country-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo __('Redirecting') ?></title>
</head>
<?php 
$onload = '';
if(Configure::read('debug') == '0') { 
	$onload = ' onload="document.forms[0].submit()"';
}
?>
<body<?php echo $onload; ?>>
<?php 
if(!isset($data['form_method'])) {
	$data['form_method'] = 'post';
}
?>
<form action="<?php echo $data['form_action']; ?>" method="<?php echo $data['form_method'] ?>">
<?php foreach($data as $key => $value) {?>
    <input name="<?php echo $key; ?>" type="hidden" value="<?php echo $value; ?>" />
<?php } ?>
<?php if(Configure::read('debug') != '0') { ?>
<button type="submit"><?php __('Send'); ?></button>
<?php } else { ?>
<noscript>
<button type="submit"><?php __('Send'); ?></button>
</noscript>
<?php } ?>
</form>
<?php 
if(Configure::read('debug') != '0') { 
	debug($data);

echo '<pre class="cake-debug">&lt;form action="' . $data['form_action'] . '" method="post">' . "\n";
foreach($data as $key => $value) {
	echo "\t" . '&lt;input name="' . $key . '" type="hidden" value="' . $value . '" />' . "\n";
}
echo '&lt;/form>' . "\n";
echo '</pre>';
}
?>
</body>
</html>