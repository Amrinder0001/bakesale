<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
body {
color: #444;
background:#eee;
font-size: 76%;
font-family: Verdana, Arial, Helvetica, sans-serif;
width:60em;
margin:0 auto;
border:1px solid #ccc;
}

#content {
padding:1em 2em;
background-color:#FFFFFF;
}

/* form*/

fieldset{
padding:1.5em;
background:#eee;
border:1px solid #ccc;
margin-bottom:2em;
}

div.input {
margin-bottom:0.5em;
}

div.input label{
width:12em;
float:left;
text-align:right;
padding-right:0.5em;
padding:0.2em 0.5em;
}

div.submit {
margin-top:1em;
padding-left:13em;
}

/* errors */

#error-report {
background:#fcc;
margin:0;
}

div.error span.text {
clear:both;
display:block;
margin-left:8em;
}

div.error {
background:#fcc;
font-weight:bold;
padding:0.5em;
}

div#flashMessage {
background:#fee;
padding:1em;
border:1px solid red;
}
-->
</style>
</head>

<body>
<div id="content">
<?php 
Configure::write('debug', 1);
 $session->flash();
echo $form->create('Payment', array('url' => '/payment/' . $this->params['controller'] . '/card/'));
   echo $form->input('card_holder');
   echo $form->input('card_number');
   echo $form->input('', array('label' => 'Expiry Date',
   'dateFormat' => 'MY',
   'minYear' => date('Y'),
   'maxYear' => date('Y') + 10,
   'type' => 'date'));
foreach($fields as $key => $row) {
	if(!is_array($row)) {
    echo $form->input($row);
	} else {
    echo $form->input($key, array('options' => $row));	
	}
}
echo $form->end('Send');
?>
</div>
</body>
</html>
