$(function() {

	$('#headerBtn').on('click', function(e) {

		e.preventDefault();

		$('.header').toggleClass('hide');

	});

	$('#moreBtn').on('click', function(e) {

		e.preventDefault();

		$('.more').toggleClass('show');

	});

	$('.close-more').on('click', function(e) {

		e.preventDefault();

		$('.more').removeClass('show');

	});

});