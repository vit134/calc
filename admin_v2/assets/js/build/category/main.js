$(document).ready(function() {
    console.log('all categories page');

    var $deleteCatBtn = $('.js-delete-cat-btn'),
        $confirmModal = $('.js-modal-confirm-delete'),
        $modal = $('#modal-delete');



    $deleteCatBtn.on('click', function(e) {
        e.preventDefault();
        console.log(123);
        var id = $(this).attr('data-cat-id');
        var href = $confirmModal.attr('href');


        href = href.split('=');
        console.log(href, href[0], href[1]);

        href = href[0] + '=' + id;
        console.log(href);
        $confirmModal.attr('href', href);

        $modal.modal();

    })
})