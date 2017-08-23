$(document).ready(function() {
    console.log('service');

    var $popup = $('#popup_service')
      , $scrollContainer = $('.js-scroll-container')
      ;

    $popup.popup({
        scrolllock: true
    });

    /*$popup.on('scroll', function() {
        console.log(13);
    })*/

    console.log($scrollContainer);
    //$scrollContainer.customScrollbar();
})