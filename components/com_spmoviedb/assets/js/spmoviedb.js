/**
* @package     SP Movie Databse
* @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
* @license     GNU General Public License version 2 or later.
*/

jQuery(function($) {

	$('.sp-moviedb-rating.can-rate').find('span.star').on('click', function(event) {
		event.preventDefault();
		var $ratings = $(this).parent().find('span.star');
		$ratings.removeClass('active');

		for (var i = $(this).data('rating_val') - 1; i >= 0; i--) {
			$ratings.eq(9-i).addClass('active');
		}

		$('#form-movie-review').find('#input-rating').val($(this).data('rating_val'));
		$(this).parent().next('.spmoviedb-rating-summary').find('>span').text($(this).data('rating_val'));
		$('#form-movie-review').find('#input-review').focus();
	})

	$('#form-movie-review').on('submit', function(event) {
		event.preventDefault();

		var value   = $(this).serializeArray();
		$.ajax({
			type: 'POST',
			url: spmoviedb_url + "&task=review.add_review&format=json",
			data: value,
			beforeSend: function() {
				$('.reviewers-form').addClass('sp-loader');
			},
			success: function (response) {

				var data = $.parseJSON(response);

				if(data.status) {

					$('.reviewers-form').removeClass('sp-loader')

					if(data.update) {
						$('#reviewers-form-popup').prepend($('<p class="alert alert-success text-center"><strong>'+ Joomla.JText._('COM_SPMOVIEDB_REVIEW_UPDATED') +'</strong></p>').hide().fadeIn());
						$('#submit-review').attr('disabled', 'disabled');

						setInterval(function() {
							$('#reviewers-form-popup').fadeOut(200, function() {
								window.location.reload(true);
							})
						}, 1500);

						$('.own-review').empty().html($(data.content).html());
					} else {
						$('.reviewers-form').fadeOut(200, function() {
							$(this).remove();
						});
						$('.reviewers-form').after(data.content);
					}
				} else {
					alert(data.content);
				}
			}
		})
})

/* Load More */
$('#spmoviedb-load-review').on('click', function(event) {
	event.preventDefault();
	$this = $(this);

	$.ajax({
		type : 'POST',
		url: spmoviedb_url + '&task=review.reviews&movie_id&format=json',
		data: {'movie_id': $(this).data('movie_id'), 'start': $('#reviews').find('>.review-item').length},
		beforeSend: function() {
			$this.find('.fa').removeClass('fa-refresh').addClass('fa-spinner fa-spin');
		},
		success: function (response) {
			var data = $.parseJSON(response);

			if(data.status) {
				$('#reviews').append(data.content);

				$this.find('.fa').removeClass('fa-spinner fa-spin').addClass('fa-refresh');

				if(!data.loadmore) {
					$this.remove();
				}
			}
		}
	})
});

$('#spmoviedb-my-review').on('click', function(event) {
	event.preventDefault();
	$('body').addClass('reviewers-form-popup-open')
	$('#reviewers-form-popup').show();
})

$('#reviewers-form-popup .close-popup').on('click', function(event) {
	event.preventDefault();
	$('body').removeClass('reviewers-form-popup-open');
	$('#reviewers-form-popup').hide();
})
});


jQuery(document).ready(function($) {

	$('.play-video').on('click', function(event) {
		event.preventDefault();
		var $that 		= $(this),
		type 		= $that.data('type'),
		videoUrl 	= $that.attr('href'), $video;

		if ( type === 'youtube' ) {
			$video = '<iframe id="video-player" src="' + videoUrl + '?rel=0&amp;showinfo=0&amp;controls=1&amp;autoplay=1" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
		}
		else if ( type === 'vimeo' ) {
			$video = '<iframe id="video-player" src="' + videoUrl + '?autoplay=1&color=ffffff&title=0&byline=0&portrait=0&badge=0" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
		} else if ( type === 'dailymotion' ) {
			$video = '<iframe id="video-player" src="' + videoUrl + '?autoplay=1&color=ffffff&title=0&byline=0&portrait=0&badge=0" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
		} else if ( type === 'self' ) {
			$video = '<video id="video-player" controls autoplay> <source src="'+ videoUrl +'">Your browser does not support the video tag.</video>';
		}

		$('.video-list').slideUp();
		$('.video-container').find('#video-player').remove();
		$('.video-container').prepend( $video );
		$('.video-container').fadeIn();
	});


	$('.video-close').on('click', function(event) {
		event.preventDefault();
		$('.video-container').fadeOut(600, function(){
			$('#video-player').remove();
		});
	});

	$('.video-list-button').on('click', function(event) {
		event.preventDefault();
		$('.video-list').slideToggle();
	});

	/* movie list sorting */
	$('select#sorting-by-years').on('change', function () {
		window.location = $(this).val();
	})

	/* Load Movie Trailer */
	$('.show-movie-trailers').on('click', function(event) {
		event.preventDefault();
		var itemId = $(this).data('id');
		$.ajax({
			type : 'POST',
			url: spmoviedb_url + '&task=movies.trailers&id='+ $(this).data('id') +'&format=json',
			beforeSend: function() {
				/* $('.reviewers-form').addClass('sp-loader') */
			},
			success: function (response) {

				var data = $.parseJSON(response);

				if(data.status) {
					var windowWidth  = $('#moviedb-item-wrap').width();
					var currentItem	 = $('.item.item-id-'+itemId);
					var parent = currentItem.parent();

					$('.view-trailers .active').removeClass('active');

					currentItem.addClass('active');

					if ( $( "#movie-trailer-video" ).length) {
						$('#movie-trailer-video').remove();
					}

					$(parent).after( '<div id="movie-trailer-video"></div>' );
					var movieTrailer = $('#movie-trailer-video');
					$(movieTrailer).append( '<div class="moviedb-trailer-loader"><i class="spmoviedb-icon-spinner spmoviedb-icon-spin"></i></div>' );

					setTimeout(function(){
						$('.moviedb-trailer-loader').remove();
						movieTrailer.slideDown("normal", function() { $(this).append(data.content); } );
					}, 300);

					$('html, body').animate({
						scrollTop: $(movieTrailer).offset().top - $(window).height() / 3
					}, 300);

				}

			}
		})
	});

	$('.view-trailers .video-close').live('click',function () {
		$('.view-trailers .active').removeClass('active');
		$('#movie-trailer-video').slideUp("normal", function() { $(this).remove(); } ); 
	});
});