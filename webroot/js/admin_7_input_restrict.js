/**
 * create closure
 */
(function($) {
// plugin definition

	$.fn.inputRestrict = function(options) {
		$(this).each(function() {
			this.value = $.fn.inputRestrict.remTrailingZeros(this.value);
		}).keyup(function() {
			$.fn.inputRestrict.res(this,'-0123456789.');
		});
	};

// remove trailing zeros definition

	$.fn.inputRestrict.remTrailingZeros = function(x) {
		var decPos=x.indexOf(".");
		if (decPos>-1) {
			first=x.substring(0,decPos);
			second=x.substring(decPos,x.length);
			while (second.charAt(second.length-1)=="0") {
			    second=second.substring(0,second.length-1);
}
			if (second.length>1){
				return first+second;
			} else {
				return first;
}
		}
		return x;
	};

// restrict form input

$.fn.inputRestrict.res = function(t,v){
	var w = "";
	for (i=0; i < t.value.length; i++) {
		x = t.value.charAt(i);
		if (v.indexOf(x,0) != -1) {
			w += x;
                }
		}
		t.value = w;
	};



// end of closure

})(jQuery);