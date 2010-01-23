<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>BakeSale Installer</title>
<style type="text/css">
<!--
body {
color: #444;
background:#eee;
font-size: 76%;
font-family: Verdana, Arial, Helvetica, sans-serif;
width:60em;
margin:2em auto;
border:1px solid #ccc;
}

#content {
padding:100px 2em 1em 2em;
background:#fff  url(<?php echo $html->url('/img/logo.jpg'); ?>) no-repeat 20px 20px;
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

div.input:after {
content: "."; 
display: block; 
height: 0px;
clear: both; 
visibility: hidden;
}

/**/

div.input.checkbox {
padding-left:12.5em;
}

div.input.checkbox label {
display:block;
width:auto;
float:left;
}

div.input.checkbox input {
float:left;
background:#ffe;
width:auto;
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
font-weight:bold;
padding:0.5em;
background:#fcc;
margin:1em 0;
border:1px solid red;
}

-->
</style>
</head>

<body>
<div id="content">
<?php $session->flash(); ?>
<?php echo $content_for_layout; ?>
</div>
</body>
</html>
