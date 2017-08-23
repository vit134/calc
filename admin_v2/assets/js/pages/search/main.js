$(document).ready(function() {
    console.log('search');

    var $searchItem = $('.js-search-item');
    var $searchInput = $('.js-search-input');



    for (var i = 0; $searchItem.length > i; i++) {
        var searchInputVal = $searchInput.val();
        var html = $searchItem.eq(i).html();

        if (html.indexOf(searchInputVal) === -1) {
            searchInputVal = searchInputVal.charAt(0).toUpperCase() + searchInputVal.substr(1);
        }

        var replace = '<span class="search__find">' + searchInputVal + '</span>';
        var insert = html.replace(searchInputVal, replace);

        $searchItem.eq(i).html(insert);
    }


})