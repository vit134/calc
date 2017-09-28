$(document).ready(function() {
    console.log('all service page');

    var $deleteCatBtn = $('.js-delete-res-btn'),
        $confirmModal = $('.js-modal-confirm-delete'),
        $modal = $('#modal-delete');



    $deleteCatBtn.on('click', function(e) {
        e.preventDefault();
        var id = $(this).attr('data-res-id');
        var href = $confirmModal.attr('href');

        href = href.split('=');
        href = href[0] + '=' + id;
        $confirmModal.attr('href', href);

        $modal.modal();
    })
})