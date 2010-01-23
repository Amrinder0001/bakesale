$(function(){ //on document ready
  var fromLanguage = $('h1').attr('id');
  $("td.google-suggestion").each(function (i) {
      $(this).translate('en', fromLanguage);
   });
	var tableColumnCount = $("th").length;
	alert(tableColumnCount);
})