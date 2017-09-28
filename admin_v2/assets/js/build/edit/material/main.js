$(document).ready(function() {
    var inpElem = document.getElementById('image'),
        img = $('.preview-edit'),
        popup = $('.js-popup'),
        popupSubmit = $('.js-popup-submit'),
        popupClose = $('.js-popup-close'),
        $cropper;


    inpElem.addEventListener("change", function() {
        preview(this.files[0]);
    });

    $cropper = $('.preview-edit');

    $cropper.cropper({
        background: false,
        autoCropArea: 1,
        preview: ".extra-preview",
        aspectRatio: 1 / 1,
        crop: function(data) {
            $('.js-x1').val(data.x);
            $('.js-y1').val(data.y);
            $('.js-width').val(data.width);
            $('.js-height').val(data.height);
        }
    })


    function preview(file) {
        if ( file.type.match(/image.*/) ) {
            var reader = new FileReader();
            reader.addEventListener("load", function(event) {
                img.attr('src',event.target.result);
                popup.show();

                $cropper.cropper("replace", event.target.result)
            });

            reader.readAsDataURL(file);
        }
    }

    popupSubmit.on('click', function() {
        popup.hide();
    })

    popupClose.on('click', function() {
        popup.hide();
        inpElem.value = "";
    })
})