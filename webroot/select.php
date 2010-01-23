<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript" charset="utf-8">
$(function(){
    $.getJSON("http://bs13.putkonen.net/countries.json",{id: $(this).val(), ajax: 'true'}, function(j){
      var options = '';
      for (var i = 0; i < j.length; i++) {
        options += '<option value="' + j[i].code + '">' + j[i].name + '</option>';
      }
      $("body").append('<select>' + options +'</select>');
    })
})
</script>
<title>Untitled Document</title>
</head>

<body>
</body>
</html>
