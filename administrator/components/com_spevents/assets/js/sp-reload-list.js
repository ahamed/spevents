(function( $ ) {

    $.fn.spreloadlist = function(options){
        var options = $.extend({
            clickBtnSelector: '',
            modalSelector: '',
            triggerBtnSelector: '',
            reloadSectionSelector: ''
        }, options);

        return this.each(function(){

            const clickBtnSelector      = options.clickBtnSelector;
            const modalSelector         = options.modalSelector;
            const triggerBtnSelector    = options.triggerBtnSelector;
            const reloadSectionSelector = options.reloadSectionSelector;

            $(function(){
                $(modalSelector + " " + clickBtnSelector).click(function (e) {
                    $(modalSelector + " iframe").contents().find(triggerBtnSelector).click();
                    $(modalSelector).modal('hide');
                    $.get(location.href)
                    .then(function (page) {
                        $(reloadSectionSelector).html($(page).find(reloadSectionSelector).html());
                        var data = $(reloadSectionSelector).val();
                        for (var i = 0; i < data.length; i++) {
                            data[i] = data[i].replace(/^\s*/, "").replace(/\s*$/, "");
                        }
                        $(reloadSectionSelector).val(data).trigger("liszt:updated");
                    });
                });
            });
        });
    }

})( jQuery );