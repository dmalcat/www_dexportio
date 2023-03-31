// jQuery fullscreen-menu script example.

// Click to toggle the hamburger-icon animation and add the fullscreen-menu overlay.
$(document).ready(function(){
	$('.hamburger').click(function(){
		$(this).toggleClass('animate-icon');
		$('#overlay').fadeToggle();
		$('#overlay .headerNavigation').addClass('headerNavigation--mobile');
		$('body').toggleClass('hamburger-open');
	});
});

// Clicking anywhere on the overlay closes the fullscreen-menu overlay and resets hamburger-icon.

$(document).ready(function(){
	$('#overlay').click(function(){
		$('.hamburger').removeClass('animate-icon');
		$('#overlay').toggle();
		$('#overlay .headerNavigation').removeClass('headerNavigation--mobile--mobile');
		if ($('body').hasClass('hamburger-open')) {
			$('body').removeClass('hamburger-open');
		}
	});
});
