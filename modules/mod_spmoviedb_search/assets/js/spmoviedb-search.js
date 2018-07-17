/**
 * @package     SP Movie Database
 * @subpackage  mod_splmscoursesearch
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

jQuery(function($) {

    $('.mod-spmoviedb-search #moviedb-search').submit(function() {
        var searchtype = $('.mod-spmoviedb-search #searchtype').val();
        var rooturl    = $('.mod-spmoviedb-search #rooturl').val();
        var searchword = $('.mod-spmoviedb-search #searchword').val();
        var mid        = $('.mod-spmoviedb-search #mid').val();
        var cid        = $('.mod-spmoviedb-search #cid').val();
        var tid        = $('.mod-spmoviedb-search #tid').val();

        var itemId = '';
        if (searchtype == 'celebrities') {
            var itemId = cid;
        } else if (searchtype == 'trailers') {
            var itemId = tid;
        } else{
            var itemId = mid;
        }
        
        if (searchword) { // require a URL
          window.location = rooturl + 'index.php?option=com_spmoviedb&view=searchresults&searchword=' + searchword +'&type='+ searchtype + itemId + ''; // redirect
        }
        return false;
    });


    var searchPreviousValue,
        liveSearchTimer
        
    $('.spmoviedb-search-input').on('keyup', function(event) {

        event.preventDefault();

        //Return on escape
        if(event.keyCode==27) {
            $('.spmoviedb-search-results').fadeOut(400);
            return;
        }

        var icon = $('.mod-spmoviedb-search .spmoviedb-search-icons').find('i');

        if ($(this).val() != searchPreviousValue) {

        var query = $(this).val().trim();

        // Remove Special Charecter
        var re = /[`~!@#$%^&*_|+\=?;:'",.<>\{\}\[\]\\\/]/gi;
        var isSplChar = re.test(query);
        if(isSplChar){
            var query = query.replace(/[`~!@#$%^&*_|+\=?;:'",.<>\{\}\[\]\\\/]/gi, '');
            $(this).val(query);
        }

        if (liveSearchTimer) {
            clearTimeout(liveSearchTimer);
        }

        if(query=='') {
            $('.spmoviedb-search-results').fadeOut(400);
        } else {
            $('.spmoviedb-search-results').fadeIn(400);
        }

        query = query.trim();

        if(query !='' && !isSplChar) {
            liveSearchTimer = setTimeout(function () {

              $.ajax({
                type: 'POST',
                url: 'index.php?option=com_ajax&module=spmoviedb_search&format=json',
                data: {type: $('.mod-spmoviedb-search #searchtype').val(), query: query},
                beforeSend: function() {
                    icon.removeClass('spmoviedb-icon-search').addClass('spmoviedb-icon-spinner spmoviedb-icon-spin');
                },
                success: function (response) {
                    icon.removeClass('spmoviedb-icon-spinner spmoviedb-icon-spin').addClass('spmoviedb-icon-search');
                    var data = $.parseJSON(response);
                    $('.spmoviedb-search-results').html(data.content);
                }
            });
          }, 300);
        }

        searchPreviousValue = $(this).val()
    }
        
        return false;
    });

    // click outside slideup
    $(document).on('click', function(e) {
        if (!$('.spmoviedb-search-results').is(e.target) && !$('.spmoviedb-search-results *').is(e.target)) {
            $('.spmoviedb-search-results').fadeOut(400);
        }
    });

});