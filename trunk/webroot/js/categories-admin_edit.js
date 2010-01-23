function setupOneClickUploadForm(form) {
	var uploadButtonText = $(form +' button').text();
	$(form).after('<button id="upload1" class="btn" href="#"><span><span>' +uploadButtonText +'</span></span></button><pre id="progress1"></pre>');
	$(form).hide();
}

function CategoryAddImageForm () {
	var formAction = $('#CategoryAddImageForm').attr('action');
	var formFieldName = $('#CategoryFile').attr('name');
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

function uploadOnSubmit() {
    $('#CategoryImage img, #CategoryImage a, div.error').remove();
    $('#CategoryImage').prepend('<div class="loading"></div>');
}

//Called after form has been submitted thru one click upload

function uploadOnComplete(data) {
	var json =  eval('(' + data + ')');
	var id = $('#CategoryId').attr('value');

	if (json.error === undefined) {
    $('div.loading').append('<img src="' +json.full +'/>').removeClass('loading');
	} else {
    $('div.loading').remove();
    notify(json.error);
	}
}


$(document).ready(function() {
	setupOneClickUploadForm('#CategoryAddImageForm');
	CategoryAddImageForm();

});