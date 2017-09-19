/* eslint no-console: 0 */
$(document).ready(function() {

    var $modal = $('#modal-2'),
        $openMOdalBtn = $('.js-open-modal'),
        $avatarInput = $('.js-avatar-input'),
        $previewImage = $('.js-preview-image'),
        $changePassBtn = $('.js-change-pass-btn'),
        $passBlock = $('.js-pass-block');

    $('#date-popup').datepicker({
        keyboardNavigation: false,
        forceParse: false,
        todayHighlight: true
    });

    $openMOdalBtn.on('click', function(e) {
        e.preventDefault();
        $modal.modal();
    })

    $modal.on('hidden.bs.modal', function () {
        var $radio = $(this).find('.js-radio');
        var radioVal;

        $radio.each(function() {
            if ($(this).prop("checked")) {
                radioVal = $(this).val();
                $avatarInput.val(radioVal);
                $previewImage.attr('src', radioVal);
            }
        })
    })

    $changePassBtn.on('click', function() {
        var $inputs = $passBlock.find('input');

        if (!$passBlock.hasClass('open')) {


            $inputs.each(function() {
                var dataValid = $(this).attr('data-validation') ? $(this).attr('data-validation') : '';
                $(this).attr('data-validation', dataValid + ' required')
            })

            $passBlock.slideDown(200).addClass('open');
        } else {
            $passBlock.slideUp(200).removeClass('open');

            $inputs.each(function() {
                var dataValid = $(this).attr('data-validation') ? $(this).attr('data-validation') : '';
                console.log(dataValid);
                if (dataValid.indexOf('confirmation') + 1) {
                    $(this).attr('data-validation', 'confirmation');
                } else {
                    $(this).attr('data-validation', '')
                }

            })
        }
    })

    $.validate({
        form: '#edit-user',
        modules: 'security',
        scrollToTopOnError: false,
        lang: 'ru'
    });
})