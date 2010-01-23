
//setup table
function tableRefresh () {
	$('tbody input[type="checkbox"]:checked').each(function(i) {
		$(this).parents('tr').remove();
	});
	zebraTable();
}


	function subproductAddFormValidates () {
		$('#SubproductAddForm p.error').remove();
		var subproductName = $('input#SubproductName').attr('value');
		if(subproductName == '') {
			$('#SubproductAddForm').append('<p class="error">Name is required</p>');
			return false;
		}
		return true;
	}
//setup subproducts edit form

function SubproductAddForm () {
	$('tbody:empty').parents('form').hide();
	$('#SubproductAddForm').ajaxForm({
		dataType: 'json',
		success: function(data) {
			var fields = ['name', 'price', 'quantity', 'weight', 'id'];
			$('tr.latest').attr('id', 'subproduct-' +data.id);
			$('tr.latest input[name*=[name]]').attr('value', data.name).attr('name', 'data[Subproduct][' +data.id +'][name]');
			$('tr.latest input[name*=[price]]').attr('value', data.price).attr('name', 'data[Subproduct][' +data.id +'][price]');
			$('tr.latest input[name*=[quantity]]').attr('value', data.quantity).attr('name', 'data[Subproduct][' +data.id +'][quantity]');
			$('tr.latest input[name*=[id]]').attr('value', data.id).attr('name', 'data[Subproduct][' +data.id +'][id]');
			$('tr.latest input[name*=[weight]]').attr('value', data.weight).attr('name', 'data[Subproduct][' +data.id +'][weight]');
			$('tr.latest input[name*=[delete]]').attr('value', data.id).attr('name', 'data[Subproduct][' +data.id +'][id]');
			$('tr.latest').fadeTo("fast", 1);
			$('#Subproduct tr').removeClass('latest');
			refreshlinks();
			dndtables();
		},
		beforeSubmit: 
			function() {
				if(subproductAddFormValidates()) { 
					$('tbody:empty').parents('form').show();
					var newRow = $('#Subproduct tbody:first').children('tr').eq(0).clone();
					$('#Subproduct tbody:first').prepend(newRow);
					$('#Subproduct tbody:first tr:first').addClass('latest');
					$('tr.latest input').attr('value', '');
					$('tr.latest').fadeTo("fast", 0.1);
				}
		}
	});
}

//setup subproducts add form

function SubproductUpdateMultipleForm () {
	$('#SubproductUpdateMultipleForm').ajaxForm({
		success: function($data) {
			$('#Subproduct table').fadeTo("fast", 1);
			cssClass('name, sort');
			dndtables();
			zebraTable();
		},
		beforeSubmit: function() {
			$('#Subproduct table').fadeTo("fast", 0.2);
		}
	});
}

//setup product image add form

function ProductAddImageForm () {
	var formAction = $('#ProductAddImageForm').attr('action');
	var formFieldName = $('#ProductFile').attr('name');
	$('#upload1').upload({
		action: formAction,
		name: formFieldName,
		onSubmit: function() {
			uploadOnSubmit();
		},
		onComplete: function(data) {
			uploadOnComplete(data);
		}
	});
}

//Called after form has been submitted thru one click upload

function setupOneClickUploadForm() {
	alert('perkele');
	var uploadButtonText = $('#ProductAddImageForm button').text();
	$('#ProductAddImageForm').after('<button id="upload1" class="add">' +uploadButtonText +'</button>');
	$('#ProductAddImageForm').hide();
}

//Called after form has been submitted thru one click upload

function uploadOnSubmit() {
	if ($("div.images ul.cols").length === 0 ) {
		$('div.images').prepend('<ul class="cols"></ul>');
	}
	$("ul.cols").append('<li class="loading"></li>');
	$('div.error').remove();
}

//Called after form has been submitted thru one click upload

function uploadOnComplete(data) {
	var json =  eval('(' + data + ')');
	var id = $('#ProductId').fieldValue();
	var model = 'Product';
	if (json.error === undefined) {
		$('li.loading').append('<img src="' +json.full +'/>').append('<a href="' +json.file +'" class="delete"><?php __('Delete')?></a>').append('<a href="' +json.file +'" class="default"><?php __('Default')?></a>').removeClass('loading');
	} else {
		$('.loading').remove();
		$('ul.cols').prepend('<div class="error">' +json.error +'</div>');
	}
}


//Initiate all functions required on page load

$(function() {
	$('ul.cols img[src*=error]').parents('li').remove(); 
	$("td a.delete").live("click", function() { 
		$.get(this.href);
		$(this).parents('tr').remove();
		return false; 
	})
	setupOneClickUploadForm();
  	SubproductAddForm();
	SubproductUpdateMultipleForm();
	ProductAddImageForm();

	jQuery().ajaxStop(function(){
		$("ul:empty").remove();
	});
	var p = $('#SubproductAddForm');
	$("select[multiple]").asmSelect({
		addItemTarget: 'bottom',
		animate: true,
		highlight: true,
	});			

	$('#Image a.delete').bind('click', function(){
		$.get(this.href);
		$(this).parent('li').remove();
		return false;
    });
	
	$('#Image a.default').bind('click', function(){
		$.get(this.href);
		var current = $(this).parent('li');
		$(this.parentNode.parentNode).prepend(current);
		return false;
    });
});
