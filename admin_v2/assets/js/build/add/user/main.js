$(document).ready(function() {
    $('#date-popup').datepicker({
        keyboardNavigation: false,
        forceParse: false,
        todayHighlight: true,
        format: "d M yyyy",
        toDisplay: function (date, format, language) {
            console.log(language);
        }
    });
})