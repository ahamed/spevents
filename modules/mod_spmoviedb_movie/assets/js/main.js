/**
* @package     SP Movie Database
* @subpackage  mod_spmoviedb_movie
*
* @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
* @license     GNU General Public License version 2 or later.
*/

jQuery(function($) {


   // $('.mod-spmoviedb-movie .owl-stage-outer').hide();
    $('.mod-spmoviedb-movie').append( '<div class="container mod-moviedb-loader-wrap"><div class="mod-moviedb-movie-loader"><div class="moviedb-signal-animate"></div></div></div>' );

    setTimeout(function(){
       $('.mod-spmoviedb-movie .owl-stage-outer').show();
       $('.mod-moviedb-loader-wrap').remove();
    }, 400);


    var $spmvmovie = $('.sp-mv-movie');
    var $autoplay   = $spmvmovie.attr('data-autoplay');
    if ($autoplay == 'true') { var $autoplay = true; } else { var $autoplay = false};
    var $slidelimit   = parseInt($spmvmovie.attr('data-slidelimit'));

    $spmvmovie.owlCarousel({
        loop:true,
        dots:false,
        nav:false,
        autoplay:$autoplay,
        autoplayTimeout:3000,
        autoplayHoverPause:true,
        autoHeight: false,
        lazyLoad:false,
        responsive:{
            0:{
                items:1
            },
            420:{
                items:2
            },
            767:{
                items:3
            },
            1000:{
                items:$slidelimit
            }
        }
    })
});



jQuery(document).ready(function($) {

    $('.mod-spmoviedb-movie .play-video').on('click', function(event) {
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

        $('.mod-spmoviedb-movie .video-list').slideUp();

        $('.mod-spmoviedb-movie .video-container').find('#video-player').remove();

        $('.mod-spmoviedb-movie .video-container').prepend( $video );

        $('.mod-spmoviedb-movie .video-container').fadeIn();
    });

    $('.mod-spmoviedb-movie .video-close').on('click', function(event) {
        event.preventDefault();
        $('.mod-spmoviedb-movie .video-container').fadeOut(600, function(){
            $('.mod-spmoviedb-movie #video-player').remove();
        });
    });

    $('.mod-spmoviedb-movie .video-list-button').on('click', function(event) {
        event.preventDefault();
        $('.mod-spmoviedb-movie .video-list').slideToggle();
    });
});