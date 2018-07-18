/**
 * @package SP repeatable field
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2018 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */

( function ($) {

    $.fn.sprepeat = function (options)
    {
        var options = $.extend({
            base_url : '',
            common_name : '',
            id: ''
        }, options);

        return this.each( function () {

            const base_url      = options.base_url;
            const common_name   = options.common_name;
            const id            = options.id;

            /* ========================================================================
             * clone and append the desire fields
             * ======================================================================== */

            $(document).on("click", "#spevents-add-new-section-" + id, function (e) {
                e.preventDefault();
                var clone = $("#sprepeat-" + id + " .spevents-clonable:first-child").clone();
                clone.find("input, textarea").each(function () {
                    $(this).val("");
                });
                clone.find(".sp-media-preview").each(function () {
                    $(this).attr("src", base_url + "images/no-preview.jpg");
                });
                $("#sprepeat-" + id + " .spevents-section-container").append(clone);

                
                var count = 0;
                $("#sprepeat-" + id + " .spevents-clonable").each(function () {

                    $(this).find("input, textarea, select").each(function () {
                        let name = $(this).attr("name").split("][");
                        name[1] = common_name + count;
                        name = name.join("][");
                        $(this).attr("name", name);
                        
                        let local_id = $(this).attr('id').split('-');
                        local_id[2] = common_name + count;
                        local_id = local_id.join('-');
                        $(this).attr('id', local_id);
                    });

                    $(this).find(".sp-btn-media-manager").each(function () {
                        let id = $(this).attr("data-id").split("-");
                        id[2] = common_name + count;
                        id = id.join("-");
                        $(this).attr("data-id", id);
                    });

                    $(this).find(".sp-media-input").each(function () {
                        let id = $(this).attr("id").split("-");
                        id[2] = common_name + count;
                        id = id.join("-");
                        $(this).attr("id", id);
                    });
                    count++;
                });
            });
            /* ========================================================================
             * Append a clonable div after next of the clicked div's add button
             * ======================================================================== */

             $(document).on("click", "#sprepeat-" + id + " .spevents-add", function (event) {
                event.preventDefault();
                
                var clone = $("#sprepeat-" + id + " .spevents-clonable:first-child").clone();
                clone.find("input, textarea").each(function () {
                    $(this).val("");
                });
                clone.find(".sp-media-preview").each(function () {
                    $(this).attr("src", base_url + "images/no-preview.jpg");
                });

                var append_after = $(this).parent().parent();
                append_after.after(clone);

                var count = 0;
                $("#sprepeat-" + id + " .spevents-clonable").each(function () {

                    $(this).find("input, textarea, select").each(function () {
                        let name = $(this).attr("name").split("][");
                        name[1] = common_name + count;
                        name = name.join("][");
                        $(this).attr("name", name);

                        let local_id = $(this).attr('id').split('-');
                        local_id[2] = common_name + count;
                        local_id = local_id.join('-');
                        $(this).attr('id', local_id);
                    });

                    $(this).find(".sp-btn-media-manager").each(function () {
                        let id = $(this).attr("data-id").split("-");
                        id[2] = common_name + count;
                        id = id.join("-");
                        $(this).attr("data-id", id);
                    });

                    $(this).find(".sp-media-input").each(function () {
                        let id = $(this).attr("id").split("-");
                        id[2] = common_name + count;
                        id = id.join("-");
                        $(this).attr("id", id);
                    });
                    count++;
                });

             });

            /* ========================================================================
             * Remove a specific fieldset except the last one
             * ======================================================================== */
            $(document).on("click", ".spevents-close", function (e) {
                e.preventDefault();
                var parent = $(this).parent().parent();
                var clonables = $("#sprepeat-" + id + " .spevents-clonable");
                if (clonables.length > 1)
                    parent.remove();

                var count = 0;
                $("#sprepeat-" + id + " .spevents-clonable").each(function () {

                    $(this).find("input, textarea, select").each(function () {
                        let name = $(this).attr("name").split("][");
                        name[1] = common_name + count;
                        name = name.join("][");
                        $(this).attr("name", name);

                        let local_id = $(this).attr('id').split('-');
                        local_id[2] = common_name + count;
                        local_id = local_id.join('-');
                        $(this).attr('id', local_id);
                    });

                    $(this).find(".sp-btn-media-manager").each(function () {
                        let id = $(this).attr("data-id").split("-");
                        id[2] = common_name + count;
                        id = id.join("-");
                        $(this).attr("data-id", id);

                    });

                    $(this).find(".sp-media-input").each(function () {
                        let id = $(this).attr("id").split("-");
                        id[2] = common_name + count;
                        id = id.join("-");
                        $(this).attr("id", id);
                    });

                    count++;
                });
            });
        });
        
    }


    /* ========================================================================
     * Drag and Drop sorting (uses jquery-ui sortable)
     * ======================================================================== */

    $.fn.spsortable = function(options){
        var options = $.extend({
            id: '',
            items: '.spevents-clonable',
            common_id: '',
            common_name: ''
        }, options);

        return this.each(function(){
            const id = options.id;
            const items = options.items;
            const common_id = options.common_id;
            const common_name = options.common_name;
            $(function(){
                
                $(id).sortable({
                    cancel: 'input, textarea, button, a, select',
                    items: items,
                    cursor: 'move',
                    cursorAt: false ,
                    opacity: 1,
                    revert: false,
                    scroll: true,
                    scrollSensitivity: 10,
                    scrollSpeed: 40,
                    over: function(event, ui){
                        console.log(event);
                        console.log(ui);
                        
                    },
                    update: function(event, ui){
                        var count = 0;
                        $(common_id + " .spevents-clonable").each(function () {
                            $(this).find("input, textarea, select").each(function () {
                                let name = $(this).attr("name").split("][");
                                name[1] = common_name + count;
                                name = name.join("][");
                                $(this).attr("name", name);

                                let local_id = $(this).attr('id').split('-');
                                local_id[2] = common_name + count;
                                local_id = local_id.join('-');
                                $(this).attr('id', local_id);
                            });

                            $(this).find(".sp-btn-media-manager").each(function () {
                                let id = $(this).attr("data-id").split("-");
                                id[2] = common_name + count;
                                id = id.join("-");
                                $(this).attr("data-id", id);

                            });

                            $(this).find(".sp-media-input").each(function () {
                                let id = $(this).attr("id").split("-");
                                id[2] = common_name + count;
                                id = id.join("-");
                                $(this).attr("id", id);
                            });

                            count++;
                        });
                    }
                });
                
            });
        });
    }


    
}) ( jQuery );
