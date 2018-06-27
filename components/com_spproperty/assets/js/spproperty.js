/*------------------------------------------------------------------------
 # SP Property - Property Component by JoomShaper.com
 # ------------------------------------------------------------------------
 # author    JoomShaper http://www.joomshaper.com
 # Copyright (C) 2010 - 2016 JoomShaper.com. All Rights Reserved.
 # License - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 # Websites: http://www.joomshaper.com
 -------------------------------------------------------------------------*/

/**
 * @package     SP Property
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

jQuery(function($){ 'use strict';

    if($( "#spproperty-slider" ).length){
        // properety slider
        $('#spproperty-slider').owlCarousel({
            loop: true,
            center: true,
            margin: 0,
            autoplay: true,
            autoplayTimeout: 8000,
            smartSpeed: 700,
            dots: false,
            nav: true,
            navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 3
                }
            }
        });
    }
    
    //Ajax property visit request form
    $('.spproperty-widget-form').on('submit', function(event) {

        event.preventDefault();

        var $this   = $(this);
        //var that    = $(this);

        var $self   = $(this);
        var value   = $(this).serializeArray();
        var request = {
            'option' : 'com_spproperty',
            'task' : 'ajax',
            'data'   : value
        };

        $.ajax({
            type: 'POST',
            url: spproperty_url + "&task=property.booking&format=json",
            data: value,
            beforeSend: function() {
                $self.addClass('booking-proccess');
                $self.children('.spproperty-req-submit').prepend('<i class="fa fa-spinner fa-spin"></i>');
            },
            success: function (response) {
                var data = $.parseJSON(response);

                if(data.status) {
                    $self.removeClass('booking-proccess').addClass('booked');
                    $self.children('.spproperty-req-submit').children('.fa-spinner').remove();
                    $self.children('.spproperty-req-submit').prop('disabled', true);
                    $self.next('.spproperty-req-status').html('<p class="pbooking-success">' + data.content + '</p>').fadeIn().delay(7000).fadeOut(500);
                 } else {
                    $self.next('.spproperty-req-status').html('<p class="pbooking-error">' + data.content + '</p>').fadeIn().delay(7000).fadeOut(500);
                }
            }
        });
    });


    //Ajax Agent contact form
    $('.spproperty-agent-form').on('submit', function(event) {

        event.preventDefault();

        var $this   = $(this);
        //var that    = $(this);

        var $self   = $(this);
        var value   = $(this).serializeArray();
        var request = {
            'option' : 'com_spproperty',
            'task' : 'ajax',
            'data'   : value
        };

        $.ajax({
            type: 'POST',
            url: spproperty_url + "&task=agent.contact&format=json",
            data: value,
            beforeSend: function() {
                $self.addClass('contact-proccess');
                $self.find('#contact-submit').prepend('<i class="fa fa-spinner fa-spin"></i>');
            },
            success: function (response) {

                var data = $.parseJSON(response);

                if(data.status) {
                    $self.removeClass('contact-proccess').addClass('sent');
                    $self.find('#contact-submit').children('.fa-spinner').remove();
                    $self.find('#contact-submit').prop('disabled', true);
                    $self.next('.spproperty-cont-status').html('<p class="contact-sent">' + data.content + '</p>').fadeIn().delay(7000).fadeOut(500);
                 } else {
                    $self.next('.spproperty-cont-status').html('<p class="contact-error">' + data.content + '</p>').fadeIn().delay(7000).fadeOut(500);
                }
            }
        });
    });

});
