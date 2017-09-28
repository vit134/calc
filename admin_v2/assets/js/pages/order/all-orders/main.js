$(document).ready(function() {
    var $filterField = $('.js-filter-field')
      , $orderTable = $('.js-order-table')
      , $datePicker = $('.input-daterange')
      ;


    function init() {
        $filterField.on('change', function(e) {
            e.preventDefault();

            var data = getFormField();

            $.ajax({
                type: "GET",
                url: "/admin_v2/core/filter/order.php",
                data: data,
                beforeSend: function() {},
                success: function(data) {
                    var d = JSON.parse(data)
                    console.log(d);
                    $orderTable.html(d.html);
                }
            });
        })

        $.fn.datepicker.dates['ru'] = {
            days: ["Воскресенье", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота"],
            daysShort: ["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"],
            daysMin: ["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"],
            months: ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"],
            monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            today: "Сегодня",
            clear: "Очистить",
            format: "mm/dd/yyyy",
            titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
            weekStart: 0
        };

        $datePicker.datepicker({
            //endDate: "09.27.2017",
            todayBtn: "linked",
            clearBtn: true,
            language: "ru",
            keyboardNavigation: false,
            todayHighlight: true,
            format: 'd M yyyy',
            updateViewDate: false
        });


    }

    function getFormField() {
        var data = {};

        $filterField.each(function() {
            data[$(this).attr('name')] = $(this).val();
        })

        return data;
    }

    init();
})