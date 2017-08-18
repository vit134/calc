$(document).ready(function() {
    var $searchBtn = $('.js-search-btn')
      , $searchInput = $('.js-search-input')
      ;


    function init() {
        bindEvents();
    }

    function bindEvents() {
        $searchBtn.on('click', function() {
            if (!$(this).hasClass('open')) {
                $searchInput.addClass('open').delay(400).focus();
                $(this).addClass('open');
            } else {
                console.log('has open');

                $(this).closest('form').submit();
            }
        })
    }

    init();
})