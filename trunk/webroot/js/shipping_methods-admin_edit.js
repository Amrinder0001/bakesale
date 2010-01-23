function optionTypes(data) {
	var selection = $('#ShippingRuleAddForm div.select').clone();
	selection.find("option").each(
		function() {
			if(this.value == data.type) {
				$(this).attr("selected","selected");
			}
		}
	);
	$('body').prepend(selection);

	$("tr#shippingrule-" +data.id +" td:eq(0)").prepend(selection);
}



function ShippingRuleAddForm() {
	$('#ShippingRuleAddForm').ajaxForm({
		dataType: 'json',
		success: function(data) {
			var count = data.id + 1;
			$('#ShippingRule tbody:first').after('<tr><td><input type="hidden" name="data[ShippingRule][' +count +'][id]" value="' +data.id +'" id="ShippingRule' +count +'Id" />' +data.type +'</td><td><label for="ShippingRule' +count +'Min"><?php __('Min'); ?></label><input name="data[ShippingRule][' +count +'][min]" type="text" value="' +data.min +'" maxlength="28" id="ShippingRule' +count +'Min" /></td><td><label for="ShippingRule' +count +'Max"><?php __('Max'); ?></label><input name="data[ShippingRule][' +count +'][max]" type="text" value="' +data.max +'" maxlength="28" id="ShippingRule' +count +'Max" /></td><td><label for="ShippingRule' +count +'Price"><?php __('Hinta'); ?></label><input name="data[ShippingRule][' +count +'][price]" type="text" value="' +data.price +'" maxlength="28" id="ShippingRule' +count +'Price" /></td><td class="actions"><input type="hidden" name="data[ShippingRule][' +count +'][delete]" value="0" id="ShippingRule' +count +'Delete_" /><input type="checkbox" name="data[ShippingRule][' +count +'][delete]" value="1" id="ShippingRule' +count +'Delete" /></td></tr>');
			$('#ShippingRule table').fadeTo("fast", 1);
			zebraTable();
		},
		beforeSubmit: function() {
			$('#ShippingRule table').fadeTo("fast", 0.2);
		}
	});
}

$(document).ready(function() {
  		ShippingRuleAddForm ();
});
