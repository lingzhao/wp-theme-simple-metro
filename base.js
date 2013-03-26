jQuery(document).ready(function() {
	$("li.header-cats").hover(function() {
		$(this).children("ul").stop().show();
	}, function() {
		$(this).children("ul").stop().hide();
	})

	$('#comment').keypress(function(e) {
		if (e.ctrlKey && e.which == 13 || e.which == 10) {
			$('#commentform').submit();
		}
	});

	$('#header ul#menu li img,.search-form input#seach-form-submit').hover(function() {
		$(this).stop().fadeTo("fast", 0.5);
	}, function() {
		$(this).stop().fadeTo("fast", 1);
	});


});

