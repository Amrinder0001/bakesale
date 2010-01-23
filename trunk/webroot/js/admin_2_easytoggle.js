// tabs - jQuery plugin for accessible, unobtrusive tabs by Klaus Hartl
// http://stilbuero.de/tabs/
// Free beer and free speech. Enjoy!

$(document).ready(function() {

$.tabs = function() {
	s = new String(window.location.href);
	
	if(s.indexOf('brands') != -1) {
		var i = 1;
		var x = 2;
	} else {
		var i = 0;
		var x = 1;
	}

    var ON_CLASS = 'on';
    var id = '#tabs';
    $(id + '>div:lt(' + i + ')').add(id + '>div:gt(' + i + ')').hide();
    $(id + '>ul>li:nth-child(' + x + ')').addClass(ON_CLASS);
    $(id + '>ul>li>a').click(function() {
        if (!$(this.parentNode).is('.' + ON_CLASS)) {
            var target = $('#'+this.href.split('#')[1]);
            if (target.size() > 0) {
                $(id + '>div:visible').hide();
                target.show();
                $(id + '>ul>li').removeClass(ON_CLASS);
                $(this.parentNode).addClass(ON_CLASS);
            } else {
                alert('There is no such container.');
            }
        }
        return false;
    });
};

	$.tabs();
});
