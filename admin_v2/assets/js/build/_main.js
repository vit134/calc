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
$(document).ready(function() {
    console.log('login');


})
$(document).ready(function() {
    console.log('add category');


})
$(document).ready(function() {
    console.log('add material page');

    var $fileInput       = $('.js-file-input'),
        $imageErrorBlock = $('.js-image-error'),
        $imageWrapper    = $('.js-image-wrapper'),
        $submitBtn       = $('.js-submit-btn');

    function init() {
        /*bindEvents();
        resizeImage();*/
    }

    /*function bindEvents() {
        $fileInput.on('change', resizeImage);
    }

    function resizeImage() {
        var preview = document.querySelector('img.js-preview-img');
        var file    = document.querySelector('input[type=file]').files[0];
        var reader  = new FileReader();

        $submitBtn.attr('disabled', false);
        $imageErrorBlock.html('');

        reader.onloadend = function () {
            preview.src = reader.result;
            $imageWrapper.show();
        }

        preview.onload = function() {

            var width       = this.width,
                height      = this.height,
                proportions = width / height;

            console.log(file.size);

            if (proportions != 1) {
                $imageErrorBlock.html('Пропорции изображения не корректны. Изображение должно быть в пропорции 1:1');
                $submitBtn.attr('disabled', true);
            }

            if (width < 200) {
                $imageErrorBlock.html('Изображение слишком маленькое. Его ширина всего ' + width + 'px, минимальная ширина изображения 200px');
                $submitBtn.attr('disabled', true);
            }
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
        }
    }*/

    init();
})
$(document).ready(function() {
    console.log(123);

    $(".cropper").cropper({
        preview: ".extra-preview" // A jQuery selector string, add extra elements to show preview.
    });
})