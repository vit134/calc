$(document).ready(function() {
    console.log('add category');

    $(".select2").select2();
    $(".select2-placeholer").select2({
        allowClear: true
    });
})