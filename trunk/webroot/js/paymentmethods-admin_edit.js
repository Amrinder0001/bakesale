
$(document).ready(function() {
	$('#PaymentMethodProcessor').change(function(){
		$('#config').empty();
		if(this.value != '') {
			$(this.parentNode.parentNode).append('<div id="config"></div>');
			$('#config').load('<?php echo $html->url('/payment/'); ?>' +this.value +'/info/');
		}
	});
});
