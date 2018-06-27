/**
 * @package     SP Property Search
 * @subpackage  mod_sppropertysearch
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

jQuery(function ($) {

    $('.sp-property-search .spproperty-search').submit(function (e) {

        var rooturl     = $('.spproperty-search #url').val();
        var menuid      = $('.spproperty-search #menuid').val();
        var keyword     = $('.spproperty-search #keyword').val();
        var city        = $('.spproperty-search #city').val();
        var pstatus     = $('.spproperty-search #pstatus').val();
        var minsize     = $('.spproperty-search #min-size').val();
        var maxprice    = $('.spproperty-search #max-price').val();

        var parking     = $('.spproperty-search #parking').val();
        var zipcode     = $('.spproperty-search #zip-code').val();
        var category    = $('.spproperty-search #category').val();
        var min_price   = $('.spproperty-search #min-price').val();
        var max_price   = $('.spproperty-search #max-price').val();

        var searchitem     = '&searchitem=' + 1;

        if (keyword) {
            keyword     = '&keyword=' + keyword;
        }

        if (city) {
            city       = '&city=' + city;
        }

        if (pstatus) {
            pstatus     = '&pstatus=' + pstatus;
        }

        if (minsize) {
            minsize     = '&minsize=' + minsize;
        }

        if (max_price) {
            max_price   = '&max_price=' + max_price;
        }

        var search_queries = searchitem + keyword + city + pstatus + minsize + max_price;

        window.location = rooturl + 'index.php?option=com_spproperty&view=properties' + search_queries + menuid + '';

        return false;
    });


    $('.sp-property-search .spproperty-adv-search').submit(function (e) {

        var rooturl     = $('.spproperty-adv-search #url').val();
        var menuid      = $('.spproperty-adv-search #menuid').val();
        var keyword     = $('.spproperty-adv-search #keyword').val();
        var city        = $('.spproperty-adv-search #city').val();
        var pstatus     = $('.spproperty-adv-search #pstatus').val();
        var minsize     = $('.spproperty-adv-search #min-size').val();
        var maxsize     = $('.spproperty-adv-search #max-size').val();
        var beds        = $('.spproperty-adv-search #beds').val();
        var baths       = $('.spproperty-adv-search #baths').val();

        var parking     = $('.spproperty-adv-search #parking').val();
        var zipcode     = $('.spproperty-adv-search #zip-code').val();
        var category    = $('.spproperty-adv-search #category').val();
        var min_price   = $('.spproperty-adv-search #min-price').val();
        var max_price   = $('.spproperty-adv-search #max-price').val();

        var searchitem     = '&searchitem=' + 1;

        if (keyword) {
            keyword     = '&keyword=' + keyword;
        }

        if (city) {
            city        = '&city=' + city;
        }

        if (pstatus) {
            pstatus     = '&pstatus=' + pstatus;
        }

        if (minsize) {
            minsize     = '&minsize=' + minsize;
        }

        if (maxsize) {
            maxsize     = '&maxsize=' + maxsize;
        }

        if (beds) {
            beds        = '&beds=' + beds;
        }

        if (baths) {
            baths       = '&baths=' + baths;
        }

        if (parking) {
            parking     = '&parking=' + parking;
        }

        if (zipcode) {
            zipcode      = '&zipcode=' + zipcode;
        }

        if (category) {
            category    = '&catid=' + category;
        }

        if (min_price) {
            min_price   = '&min_price=' + min_price;
        }

        if (max_price) {
            max_price   = '&max_price=' + max_price;
        }

        var search_queries = searchitem + keyword + city + pstatus + minsize + maxsize + beds + baths + parking + zipcode + category + min_price + max_price;

        window.location = rooturl + 'index.php?option=com_spproperty&view=properties' + search_queries + menuid + '';

        return false;
    });

});
