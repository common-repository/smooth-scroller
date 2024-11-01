jQuery(document).ready(function ($) {
	var pagetop = $('#beek_smooth_scroller');
	$(window).scroll(function () {
		if ($(this).scrollTop() > 100) {
			pagetop.fadeIn(300);
		} else {
			pagetop.fadeOut(300);
		}
	});
	pagetop.click(function () {
		$('body, html').not(":animated").animate({scrollTop: 0}, 500);
		return false;
	});
});
