$(document).ready(function() {
    var $searchBtn = $('.js-search-btn')
      , $searchInput = $('.js-search-input')
      , $blocksitContainer = $('.js-blocksit-container')
      ;


    function init() {
        bindEvents();
        select2Init();

        $(".select2-placeholer").select2({
            allowClear: true
        });
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
        if ($('.select2') && $('.select2').length > 0 || $(".select2-placeholer") && $(".select2-placeholer").length > 0) {
            var placeholder = $('.select2').attr('data-placeholder');

            $(".select2").select2({
                placeholder: placeholder
            });


        }
    }

    (function($) {
        $.fn.removeClassWild = function(mask) {
            return this.removeClass(function(index, cls) {
                var re = mask.replace(/\*/g, '\\S+');
                return (cls.match(new RegExp('\\b' + re + '', 'g')) || []).join(' ');
            });
        };
    })(jQuery);



    init();
})