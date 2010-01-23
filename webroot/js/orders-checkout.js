//Add currency specific formatting to money

function formatMoney ($price) {
	var Price = $price;
	var Price = Price.replace('<?php echo Configure::read('Currency.thousands_point'); ?>', '');
	var Price = Price.replace('<?php echo Configure::read('Currency.decimal_point'); ?>', '.');
	var Price = Number(Price.replace(/[^\d\.]/g, ''));
	return Price;	
}


//run all required functions on startup
$(document).ready(function(){	
		alert('miksi');				   
		if($('#OrderCountryId option:selected').text() != 'USA') {
			$('#OrderStateId').parents('div').hide();
		}

		$("input[type='radio']:checked").parent().addClass("active");
		$("input[type='radio']").click(function(){
			//$("input[type='radio']").not("[checked]").parent().removeClass("active");
			$(this.parentNode).addClass("active");
			$("li.total").empty();
		});
		
		$("fieldset.handling input").click(function(){
			var total = formatMoney($('li#btotal span').text());
			var pcost = formatMoney($('#PaymentMethod div.active span').text());						
			var scost = formatMoney($('#ShippingMethod div.active span').text());
			var subtotal = formatMoney($('li#bsubtotal').text());
			var newshipping = pcost + scost;
			var newtotal = newshipping + subtotal;

			if(newtotal != total) {
				$("li#bshipping span").empty();
				$("li#bshipping span").prepend('<?php echo Configure::read('Currency.symbol_left'); ?>' + newshipping + '<?php echo Configure::read('Currency.symbol_right'); ?>');
				$("li#btotal span").empty();
				$("li#btotal span").prepend('<?php echo Configure::read('Currency.symbol_left'); ?>' + newtotal + '<?php echo Configure::read('Currency.symbol_right'); ?>');
			}
		});
		


		$('#OrderCountryId').change(function(){
			$(this).parents('form').append('<input type="hidden" name="verify" value="xxx" id="country" />');
			$(this).parents('form').submit();
		});

// check submitted form
		$('#OrderCheckoutForm').submit(function(){
			$('div.error span.text').remove();
			ok = true;
			if(!checkMail($('#OrderEmail').val())) {
				ok = false;
			}
			$("#billing input[type='text']").each(function(){
				if(this.value=='') { 
					ok = false;
					$(this.parentNode).addClass('error').append('<span class="text"><?php __('Required field'); ?></span>');
				} else {
					$(this.parentNode).removeClass('error');
				};                    
			});
			if($('#OrderSame:checked').length == 0) {
				$("#shipping input[type='text']").each(function(){
					if(this.value=='') { 
						ok = false;
						$(this.parentNode).addClass('error').append('<span class="text"><?php __('Required field'); ?></span>');
					} else {
						$(this.parentNode).removeClass('error');
					};                    
				});
			}
			if(ok == false) {
   				var divs = $("form#OrderCheckoutForm label").get();
				var a = [];
				for (var i = 0; i < divs.length; i++) {
					a.push(divs[i].innerHTML);
				}
			$('form#OrderCheckoutForm').prepend('<div id="error-report"><strong></strong></div>');
				$("#error-report").append(a.join(" "));
				return false;                    
			};
		});
		
		$("input#OrderSame").click(function(){
			$(this.parentNode).siblings('div.input').toggle();
		});


	});