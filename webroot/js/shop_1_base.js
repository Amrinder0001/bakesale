

$(function(){

	$('#breadcrumbs a').each(function(){
		$('#categoriesmenu a[href="'+$(this).attr('href')+'"]').addClass('current');
	});

	$('#breadcrumbs strong').each(function(){
		$('#categoriesmenu a:contains(' +$(this).text() +')').addClass('current');
	});
	
});