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