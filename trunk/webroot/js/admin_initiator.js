//Set base url for cases when shop is not installed in root of website

var baseUrl = '<?php echo $html->url('/'); ?>';

// Zebra stripe tables

function zebraTable() {
	$("table tbody tr").removeClass('or');
	$('table tbody tr:even').addClass('or');
	$('table').attr('cellspacing', 0);
}

//Instant submit form fields
function inputSetUp() {
	$('input[name*=price], input[name*=quantity], input[name*=weight], input[name*=min], input[name*=max]').inputRestrict();
}

function generateMessage(message) {
	$('<div id="flashMessage">' +message +'</div>').prependTo('body');
	//if(error) {
		$('#flashMessage').addClass('error');			
	//}
	notify();
}


function notify() {
// jQuery: reference div, load in message, and fade in
	var flash_div = $("#flashMessage");
	flash_div.html();
	flash_div.fadeIn(400);
// use Javascript timeout function to delay calling
// our jQuery fadeOut, and hide
	setTimeout(function(){
		flash_div.fadeOut(1500,
		function(){
			flash_div.html("");
			flash_div.hide();
		})},
	3000);
}

function markRequiredFields() {
	$('div.required label').append(' *');
}


function createFormButtons() {
	$("div.submit input").each(function(){
		var text = $(this).attr('value');
		var type = $(this).attr('type');
		$(this).after('<button type="' +type +'">' +text +'</button>');
		$(this).hide();
	});
}

function pageHeaderDeleteForm() {
	$("div.page-header form").each(function(){
		var text = $(this).attr('value');
		var type = $(this).attr('type');
		$(this).after('<a href="#" class="delete">Delete</a>');
		$(this).hide();
	});
}

/* Wrap images with span for easier height settings */

// Table images
function tableImgFix() {
	$('table a img[src*=uploads], table a img[src*=cache], li img[src*=uploads], li img[src*=cache]').wrap('<span class="height-fix"></span>');
}


/* these events get fired on page load and may need to be refreshed ajax calls */


function refreshlinks() {
	tableImgFix();
	zebraTable();
	inputSetUp();
	pageHeaderDeleteForm();
	$("a.status").unbind("change");
	$("a.status").click(function(){
		var p = this.firstChild;
		var altText = '<?php __('Activate'); ?>';
		var img = '0.gif';
		
		if (p.src.match('0.gif')) {
			var altText = '<?php __('Deactivate'); ?>';
			var img = '1.gif';
		} 
		$(p).attr({ src: baseUrl +'img/icons/icon_' +img, alt: altText });
		$.get(this.href);
		return false;
	});
	
	
	$('input[id*="Code"]').addClass('code');
	$('input[id*="ort"]').addClass('sort');
	$('input[id*="ame"]').addClass('name');
	$('input[id*="rice"]').addClass('price');
	$('input[id*="eight"]').addClass('weight');
	$('input[id*="uantity"]').addClass('quantity');
	$('textarea[id*="Description"]').addClass('description');
}

function dndtables(tableId) {
    $('#' +tableId).tableDnD({
	    onDragClass: "active",
	    onDrop: function(table, row) {
			var order = $.tableDnD.serialize();
			var base = '<?php echo $html->url('/admin/') ?>' +tableId +'/sort/' +order;
			$.get(base);
	    }
	});
}

/////////////////////////////////////////////////////////////////////////
$(document).ready(function() {
	notify();
	markRequiredFields();
	createFormButtons();

	if ( $("div#sbar").length > 0 ) { 
		$('body').addClass('with-sbar');
	}	
	if($("td.sort").length > 0) {
		$.getScript(baseUrl +'js/shared/jquery.tablednd.js', function(){
			var tableId = $('td.sort').parents('table').attr('id');
			setTimeout(function() {
  				dndtables(tableId);
			}, 1000);
		});
		$("td.sort").contents().remove();
	}
	
	 $("div.header ul.menu li").parents('li').addClass('indicator');
/*
    $("div.header ul.menu").supersubs({ 
            minWidth:    12,   // minimum width of sub-menus in em units 
            maxWidth:    20,   // maximum width of sub-menus in em units 
            extraWidth:  1     // extra width can ensure lines don't sometimes turn over 
                               // due to slight rounding differences and font-family 
        }).superfish({
			delay:       1000,
			animation:   {opacity:'show',height:'show'},  // fade-in and slide-down animation 
            speed:       'fast'                         
		});  // call supersubs first, then superfish, so that subs are 
            // not display:none when measuring. 
 */
	$('tbody').each(function(){
    	$(this).html($.trim($(this).html()));
  	});
	
	refreshlinks();

// Mark location to mainmenu

	$('body.c-products a.products, body.c-categories a.products, body.c-brands a.products').addClass('selected');
	$('body.c-orders a.orders').addClass('selected');
	$('body[class*="content"] a.contents').addClass('selected');
	if (!$('div.header a.selected')[0]) {
		$('a.settings').addClass('selected');
	}

// Mark checkbox classes

	$('input[checked], input[id$="Active"][checked], input[id$="Cart"][checked]').parent().attr("class","status-1");

	$('input[id$="Active"], input[id$="Cart"]').not("[checked]").parent().attr("class","status-0");
	
// toggle checkbox classes

	$('input[id$="Active"], input[id$="Cart"]').click(function(){
		var cssClass = this.parentNode.className;
		if (cssClass === 'status-1') {
			cssClass = 'status-0';
		} else {
			cssClass = 'status-1';
		}
	});

// toggle checkbox classes

	$('table input[id$="Delete"]').click(function(){
		$(this).parents('tr').addClass('deleted');
		$(this).not(':checked').parents('tr').removeClass('deleted');
	});

// refresh certain functions after ajax call

	jQuery().ajaxStop(function(){
		refreshlinks();
		zebraTable();
	});
});