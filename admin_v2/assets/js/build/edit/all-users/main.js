$(document).ready(function() {
    console.log('all users page');

    var $deleteBtn = $('.js-delete-btn'),
        $confirmModal = $('.js-modal-confirm-delete'),
        $modal = $('#modal-delete');



    $deleteBtn.on('click', function(e) {
        e.preventDefault();
        console.log(123);
        var id = $(this).attr('data-id');
        var href = $confirmModal.attr('href');


        href = href.split('=');
        console.log(href, href[0], href[1]);

        href = href[0] + '=' + id;
        console.log(href);
        $confirmModal.attr('href', href);

        $modal.modal();

    })
})