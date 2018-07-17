/**
 * @package     SP Movie Database
 * @subpackage  mod_spmoviedb_tab
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */
 
jQuery(function($) {
    
    var $spMoviewTab = $(".spmoviedb-tab-wrap");
    
    var $autoplay   = $spMoviewTab.attr('data-autoplay');
    if ($autoplay == 'true') { var $autoplay = true; } else { var $autoplay = false};
    var $slidelimit   = parseInt($spMoviewTab.attr('data-slidelimit'));

    $spMoviewTab.owlCarousel({
        margin:30,
        nav:true,
        loop:true,
        dots:false,
        autoplay:$autoplay,
        autoplayTimeout:3000,
        autoplayHoverPause:true,
        autoHeight: false,
        responsive:{
            0:{
                items:1
            },
            420:{
                items:2
            },
            767:{
                items: $slidelimit - 1
            },
            1000:{
                items: $slidelimit
            }
        }
    });
    
});


jQuery(document).ready(function($) {

    $('.mod-spmoviedb-tab .play-video').on('click', function(event) {
        event.preventDefault();
        var $that       = $(this),
        type        = $that.data('type'),
        videoUrl    = $that.attr('href'), $video;

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

        $('.mod-spmoviedb-tab .video-list').slideUp();

        $('.mod-spmoviedb-tab .video-container').find('#video-player').remove();

        $('.mod-spmoviedb-tab .video-container').prepend( $video );

        $('.mod-spmoviedb-tab .video-container').fadeIn();
    });


    $('.video-close').on('click', function(event) {
        event.preventDefault();
        $('.mod-spmoviedb-tab .video-container').fadeOut(600, function(){
            $('.mod-spmoviedb-tab #video-player').remove();
        });
    });

    $('.mod-spmoviedb-tab .video-list-button').on('click', function(event) {
        event.preventDefault();
        $('.mod-spmoviedb-tab .video-list').slideToggle();
    });

});