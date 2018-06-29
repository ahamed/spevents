/**
* @package com_spmedical
*
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

 jQuery(function($){ 'use strict';
    if($('.spmedical-specialists-list .spmedical-specialist-search').length){
        $('.spmedical-specialists-list .spmedical-specialist-search').submit(function (e) {
            var rooturl = $(this).find('#url').val(),
            menuid = $(this).find('#menuid').val(),
            specialistId = $(this).find('#spmedical-specialist').val(),
            searchitem = '&searching=' + 1;
    
            var specialist = '';
            if (specialistId) {
                specialist = '&specialistid=' + specialistId;
            }
    
            var search_queries = searchitem + specialist;
            window.location = rooturl + 'index.php?option=com_spmedical&view=specialists' + search_queries + menuid + '';
            return false;
        });
    }

    // onclick set value to inputbox search
    $(document).on('click', '.spmedial-suggest-fields .results-list li a', function (event) {
        event.preventDefault();
        var that = $(this),
        selectedValue = that.text(),
        specialistId = that.parent().data('specialistid');
        that.closest('.input-field').find('input[type="text"]').val(selectedValue).attr('data-specialistid', specialistId);
        $('.spmedial-suggest-fields .spmedical-search-results').fadeOut(400);
    });

     //onclick outside search suggestion will disapear
     $(document).on('click', '', function (e) {
         if ($(e.target).closest('.spmedical-search').length === 0) {
             //console.log('clicked');
             $('.spmedial-suggest-fields .spmedical-search-results').fadeOut(400);
         }
     });

    //spmedical specialitists filter
    $('#spmedical-specialists-filters-form').on('submit', function(event) {

        var that    = $(this);
        var rooturl = that.find('#url').val();
        var menuid  = that.find('#menuid').val();

        var departmentId    = that.find('input[name="department"]:checked').val();
        var specialityName  = that.find('input[name="speciality"]:checked').val();
        var gender_name     = that.find('input[name="gender"]:checked').val();

        var gender = '';
        if (gender_name) {
            var gender = '&gender=' + gender_name;
        }

        var speciality = '';
        if (specialityName) {
            var speciality = '&speciality=' + specialityName;
        }

        var department = '';
        if (departmentId) {
            var department = '&departmentid=' + departmentId;
        }

        var search_queries = gender + speciality + department;

        if (search_queries){
            var searchitem = '&searching=' + 1;
            var search_queries = searchitem + search_queries;
        }

        window.location = rooturl + 'index.php?option=com_spmedical&view=specialists' + search_queries + menuid + '';
        
        console.log(search_queries);

        return false;
    });

    // spmedical specialitists filter reset
    $('.spmedical-specialists-filters .reset-button').on('click', function (event) {
        $('.spmedical-specialists-filters input[type="radio"]').removeAttr('checked');
    });

    // Ajax appointment form system
    $('#spmedical-specialist-appintment-from').on('submit', function(event) {
        event.preventDefault();
        
        var that = $(this),
        specialistId = that.find('#spmedical-specialists').val(),
        patientName = that.find('input[name="patient-name"]').val(),
        phone = that.find('input[name="phone"]').val(),
        email = that.find('input[name="email"]').val(),
        appointmentDate = that.find('input[name="appointment-date"]').val(),
        patientNote = that.find('textarea[name="patient-note"]').val(),
        showcaptcha = that.find('input[name="showcaptcha"]').val(),
        captcha_response = that.find('#g-recaptcha-response').val();
        if (typeof captcha_response === "undefined") {
            var captcha_response = '';
        }

        var values = { specialist_id: specialistId, patient_name: patientName, phone: phone, email: email, appointment_date: appointmentDate, patient_note: patientNote, showcaptcha: showcaptcha, 'g-recaptcha-response': captcha_response };

        if (!specialistId.length){
            that.next('.spmedical-appointment-status').html('<p class="appointment-error">Please select a specialist.</p>').fadeIn().delay(7000).fadeOut(500);
            return false;
        }

        $.ajax({
            type: 'POST',
            url: spmedical_url + "&task=appointments.submit",
            data: values,
            beforeSend: function() {
                that.addClass('appointment-proccess');
                that.find('#appointment-submit').prepend('<i class="medico-loading sp-spin"></i>');
            },
            success: function (response) {
              var data = $.parseJSON(response);
                if (data.status) {
                    that.next('.spmedical-appointment-status').html('<p class="appointment-sent">' + data.content + '</p>').fadeIn().delay(7000).fadeOut(500);
                    that.removeClass('appointment-proccess').addClass('appointment-sent');
                    that.find('#appointment-submit').children('.medico-loading').remove();
                    that.find('#appointment-submit').prop('disabled', true);
                    that.trigger('reset');
                } else {
                    that.next('.spmedical-appointment-status').html('<p class="appointment-error">' + data.content + '</p>').fadeIn().delay(7000).fadeOut(500);
                    that.find('#appointment-submit').children('.medico-loading').remove();
                }
            }
        });
    });


    // Datepicker for appointment form
    if ($('input[name="appointment-date"]').length>0){
        jQuery(function($){
          var date_input = $('input[name="appointment-date"]');
          var options={
            format: 'yyyy/mm/dd',
            todayHighlight: true,
            autoclose: true,
          };
            date_input.datepicker(options);
        });
    }

    //For custom feature box
    $('.spmedical-departments .spmedical-department-wrap a').on('hover', function(e){
        $(this).find('.spmedical-department-details').slideToggle(300);
    });

    // Cost Estimate
    if( $('.spmedical-services-list-wrapper').length ) {
        // Custom selectbox
        $(document).on('click', function (e) {
            var selector = $('.spmedical-select');
            if (!selector.is(e.target) && selector.has(e.target).length === 0) {
                selector.find('ul').slideUp();
                selector.removeClass('active');
            }
        });

        $('.spmedical-custom-select').each(function (event) {
            $(this).hide();
            var $self = $(this);
            var spselect = '<div class="spmedical-select">';
            spselect += '<div class="spmedical-select-result">';
            spselect += '<span class="spmedical-select-text">' + $self.find('option:selected').text() + '</span>';
            spselect += ' <i class="medico-dropdown"></i>';
            spselect += '</div>';
            spselect += '<ul class="spmedical-select-dropdown">';

            $self.children().each(function (event) {
                if ($self.val() == $(this).val()) {
                    spselect += '<li class="active" data-val="' + $(this).val() + '">' + $(this).text() + '</li>';
                } else {
                    spselect += '<li data-val="' + $(this).val() + '">' + $(this).text() + '</li>';
                }
            });
            spselect += '</ul>';
            spselect += '</div>';
            $(this).after($(spselect));
        });

        $(document).on('click', '.spmedical-select', function (event) {
            $('.spmedical-select').not(this).find('ul').slideUp();
            $(this).find('ul').slideToggle();
            $(this).toggleClass('active');
        });

        $(document).on('click', '.spmedical-select ul li', function (event) {
            var $select = $(this).closest('.spmedical-select').prev('select');
            $(this).parent().prev('.spmedical-select-result').find('span').html($(this).text());
            $(this).parent().find('.active').removeClass('active');
            $(this).addClass('active');
            $select.val($(this).data('val'));
            $select.change();
        });
        // End Select

        //Services chooser
        let options = $('.spmedical-custom-select option');
        let services = Array.from(document.querySelectorAll('.spmedical-service-tests'));

        services.forEach(function (value, i) {
            value.setAttribute('data-tab', options[i].value);
            //console.log(options[i].value);
        });

        $('.spmedical-custom-select').on('change', function () {
            let Value = this.value;
            for (const service of services) {
                if (service.dataset.tab == Value) {
                    service.classList.add('active');
                } else {
                    service.classList.remove('active');
                }
            }
        });

        //Cost calculator
        let allCost = Array.from(document.querySelectorAll('.cost-checkbox'));
        $('.cost-checkbox').on('click', function () {
            var totalCosts = 0;
            for (const cost of allCost) {
                if (cost.checked) {
                    totalCosts += parseFloat(cost.value);
                }
            }
            $('.spmedical-test-total-cost').text(totalCosts);
        });
    }

    if ($('.spmedical-combobox').length){
        $(function () {
            $.widget("custom.combobox", {
                _create: function () {
                    this.wrapper = $("<span>")
                        .addClass("custom-combobox")
                        .insertAfter(this.element);
   
                    this.element.hide();
                    this._createAutocomplete();
                    this._createShowAllButton();
                },
   
                _createAutocomplete: function () {
                    var selected = this.element.children(":selected"),
                        value = selected.val() ? selected.text() : "";
   
                    this.input = $("<input>")
                        .appendTo(this.wrapper)
                        .val(value)
                        .attr("title", "")
                        .addClass("custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left")
                        .autocomplete({
                            delay: 0,
                            minLength: 0,
                            source: $.proxy(this, "_source")
                        })
                        .tooltip({
                            classes: {
                                "ui-tooltip": "ui-state-highlight"
                            }
                        });
   
                    this._on(this.input, {
                        autocompleteselect: function (event, ui) {
                            ui.item.option.selected = true;
                            this._trigger("select", event, {
                                item: ui.item.option
                            });
                        },
   
                        autocompletechange: "_removeIfInvalid"
                    });
                },
   
                _createShowAllButton: function () {
                    var input = this.input,
                        wasOpen = false
   
                    $("<a>")
                        .attr("tabIndex", -1)
                        .attr("title", "Show All Items")
                        .attr("height", "")
                        .tooltip()
                        .appendTo(this.wrapper)
                        .button({
                            icons: {
                                primary: "ui-icon-triangle-1-s"
                            },
                            text: "false"
                        })
                        .removeClass("ui-corner-all")
                        .addClass("ui-button ui-widget custom-combobox-toggle ui-corner-right")
                        .on("mousedown", function () {
                            wasOpen = input.autocomplete("widget").is(":visible");
                        })
                        .on("click", function () {
                            input.trigger("focus");
   
                            // Close if already visible
                            if (wasOpen) {
                                return;
                            }
   
                            // Pass empty string as value to search for, displaying all results
                            input.autocomplete("search", "");
                        });
                },
   
                _source: function (request, response) {
                    var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
                    response(this.element.children("option").map(function () {
                        var text = $(this).text();
                        if (this.value && (!request.term || matcher.test(text)))
                            return {
                                label: text,
                                value: text,
                                option: this
                            };
                    }));
                },
   
                _removeIfInvalid: function (event, ui) {
   
                    // Selected an item, nothing to do
                    if (ui.item) {
                        return;
                    }
   
                    // Search for a match (case-insensitive)
                    var value = this.input.val(),
                        valueLowerCase = value.toLowerCase(),
                        valid = false;
                    this.element.children("option").each(function () {
                        if ($(this).text().toLowerCase() === valueLowerCase) {
                            this.selected = valid = true;
                            return false;
                        }
                    });
   
                    // Found a match, nothing to do
                    if (valid) {
                        return;
                    }
   
                    // Remove invalid value
                    this.input
                        .val("")
                        .attr("title", value + " didn't match any item")
                        .tooltip("open");
                    this.element.val("");
                    this._delay(function () {
                        this.input.tooltip("close").attr("title", "");
                    }, 2500);
                    this.input.autocomplete("instance").term = "";
                },
   
                _destroy: function () {
                    this.wrapper.remove();
                    this.element.show();
                }
            });
   
            $(".spmedical-combobox").combobox();
            $("#toggle").on("click", function () {
                $(".spmedical-combobox").toggle();
            });

            $('.custom-combobox-toggle').html('<i class="medico-dropdown"></i>');
            $('.custom-combobox-toggle').on('click', function(){
                $(this).toggleClass('active');
            });
            $('.custom-combobox').on('click', function (e) {
                e.stopPropagation();
            })
            $(document).on('click', function(e){
                $('.custom-combobox-toggle').removeClass('active');
            })

            // Set placeholders into search fields
            let specialistPlaceholder = $('#spmedical-specialist').data('placeholder');
            let appointSpecialistPlaceholder = $('.spmedical-appointment-combobox').data('placeholder');
            $("#spmedical-specialist+.custom-combobox>.custom-combobox-input").attr("placeholder", specialistPlaceholder);
            $(".spmedical-appointment-combobox+.custom-combobox>.custom-combobox-input").attr("placeholder", appointSpecialistPlaceholder);
        });
    }

});
