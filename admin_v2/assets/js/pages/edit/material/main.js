$(document).ready(function() {
    var inpElem = document.getElementById('image'),
        img = $('.preview-edit'),
        popup = $('.js-popup'),
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
            console.log(data);
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

    $('.js-popup-submit').on('click', function() {
        popup.hide();

        console.log($cropper.cropper("getData"));
        console.log($cropper.cropper("getImageData"));
        console.log($cropper.cropper("getDataURL"));
        //$('.extra-preview').attr('src', )
    })
})