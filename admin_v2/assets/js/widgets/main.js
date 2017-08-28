$(document).ready(function() {
    var $searchBtn = $('.js-search-btn')
      , $searchInput = $('.js-search-input')
      , $blocksitContainer = $('.js-blocksit-container')
      ;


    function init() {
        bindEvents();
        select2Init()
    }

    function bindEvents() {
        $searchBtn.on('click', function() {
            if (!$(this).hasClass('open')) {
                $searchInput.addClass('open').delay(400).focus();
                $(this).addClass('open');
            } else {
                $(this).closest('form').submit();
            }
        })
    }

    function select2Init() {
        if ($('.select2') && $('.select2').length > 0) {
            var placeholder = $('.select2').attr('data-placeholder');

            $(".select2").select2({
                placeholder: placeholder
            });
        }
    }

    init();
})