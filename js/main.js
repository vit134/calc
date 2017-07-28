/* eslint no-console : 0 */
/* eslint no-unused-vars: 0 */

$(document).ready(function() {

    var $scrollContainer = $('.js-scrollable')
      , $rightScrollContainer = $('.js-right-scrollable')
      , $catOpen = $('.js-cat-open')
      , $rightCatOpen = $('.js-open-right-category')
      , addServiceButton = $('.js-add-service')
      , rightServiceBody = $('.js-right-service-body')
      , serviceSubCut = $('.js-service-subcat')
      , template = $('.js-template')
      ;

    var _add = 'Добавить'
      , _remove = 'Удалить'
      ;


    $scrollContainer.customScrollbar();
    $rightScrollContainer.customScrollbar();

    var services = [];

    var currentDate = new Date();
    currentDate.setDate(currentDate.getDate() + 1);

    var dateEnd = 0;
    var dateEndObj = new Date();

    var options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    };

    //$('.gustavs__calc__finish').html(currentDate.toLocaleString("ru", options));
    $('#date').val(currentDate.toLocaleString("ru", options));

    $.ajax({
        url: "/redirect.php",
        success: function(data){
            console.log(JSON.parse(data));
            updateServices(JSON.parse(data, true));
        }
    });

    function updateServices(data) {
        services = data;
    }

    function updateVars() {
        $rightCatOpen = $('.js-open-right-category')
    }

    $catOpen.on('click', function() {
        $(this).parent().toggleClass('open');

        var interval = setInterval(function() {
            $scrollContainer.customScrollbar("resize", true);
        }, 50)
        setTimeout(function() {
            clearInterval(interval);
        }, 400)
    })

    $('body').on('click','.js-open-right-category', function() {
        $(this).parent().parent().toggleClass('open');

        var interval = setInterval(function() {
            $rightScrollContainer.customScrollbar("resize", true);
        }, 50)
        setTimeout(function() {
            clearInterval(interval);
        }, 400)
    })

    $('body').on('click','.js-right-category-remove', function() {
        removeFromRight($(this).closest('.gustavs__calc__results__category'));
    })

    $('#date').on('input', function() {
        console.log(123);
    })

    $(".js-phone-validate").mask("+7(999) 999-99-99");

    $('#date').datepicker({
        dayNames: ["Воскресенье", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота"],
        dayNamesMin: ["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"],
        monthNames: ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"],
        firstDay: 1,
        showOn: "focus",
        dateFormat: "dd MM, yy",
        altField: "#date",
        defaultDate: 1,
        onSelect: function(e) {
            var dateTypeVar = $('#date').datepicker('getDate');

            dateEndObj = dateTypeVar;

        }

    });

    //console.log(dateEndObj);


    serviceSubCut.each(function() {
        $(this).attr('data-value', $(this).find('.gustavs__calc__service__subcategory__square').val())
        $(this).attr('data-name', $(this).find('.gustavs__calc__service__subcategory__name').html())
    })

    addServiceButton.on('click', function() {
        if (!$(this).closest(serviceSubCut).hasClass('can-remove')) {
            $(this).html(_remove);
            $(this).closest(serviceSubCut).addClass('can-remove')
            addToRight($(this).closest(serviceSubCut));
        } else {
            $(this).html(_add);
            $(this).closest(serviceSubCut).removeClass('can-remove');
            removeFromRight($(this).closest(serviceSubCut));
        }

    })

    $('.gustavs__calc__service__subcategory__square').on('keyup', function() {
        if ($(this).parent().hasClass('can-remove')) {
            reCountUnits($(this).val(), $(this).parent());
        }
    })

    $('body').on('keyup','.gustavs__calc__results__category__square', function() {
        reCountUnits($(this).val(), $(this).parent().parent());

    })


    function addToRight($row) {
        var catId = $row.attr('data-category-id')
          , servId = $row.attr('data-service-id')
          , countUnit = $row.find('.gustavs__calc__service__subcategory__square').val()
          , name = $row.attr('data-name')
          ;

        var clone = template.clone()
          , subservice = services[catId].service[servId].subservice
          , sum = 0
          , sumDay = 0
          ;

        clone.find('.gustavs__calc__results__category__name').html(name);
        clone.find('.gustavs__calc__results__category__square').val(countUnit);

        for (var item in subservice) {
            var $item = subservice[item];
            clone.find('.gustavs__calc__results__category__body').append('<div class="gustavs__calc__results__subcategory">'+ $item.name +'<div class="gustavs__calc__results__subcategory__price">'+ $item.price_for_one * countUnit  +' руб</div></div>')
            sum += $item.price_for_one * countUnit;
            sumDay += $item.day_to_do ;
        }


        $row.attr('data-count-days',  Math.round(sumDay / 60 * countUnit / 24))

        clone.removeClass('js-template');
        clone.attr('data-count-days',  Math.round(sumDay / 60 * countUnit / 24))
             .attr('data-category-id', catId)
             .attr('data-service-id', servId);

        clone.find('.gustavs__calc__results__category__body').append('<div class="gustavs__calc__results__subcategory gustavs__calc__results__subcategory_sum">Сумма<div class="gustavs__calc__results__subcategory__price">'+ sum +' руб</div></div>')
        clone.appendTo('.js-right-service-body .overview').show();

        $('.gustavs__calc__finish').html(calcDate('plus', Math.round(sumDay / 60 * countUnit / 24)));

        updateVars();
        $rightScrollContainer.customScrollbar("resize", true);

        $('.js-work-price').html(calcSumPrice() + 'Р');

    }

    function removeFromRight ($row) {
        var days = $row.attr('data-count-days')
          , catId = $row.attr('data-category-id')
          , servId = $row.attr('data-service-id')
          ;


        var leftRow = $('.gustavs__calc__service__body').find('.gustavs__calc__service__subcategory[data-category-id='+ catId +'][data-service-id='+ servId +']');
        var rightRow = $('.gustavs__calc__results__body ').find('.gustavs__calc__results__category[data-category-id='+ catId +'][data-service-id='+ servId +']');

        leftRow.removeClass('can-remove').find('.js-add-service').html(_add);
        rightRow.remove();
        $rightScrollContainer.customScrollbar("resize", true);

        $('.gustavs__calc__finish').html(calcDate('minus', days));
        $('.js-work-price').html(calcSumPrice() + 'Р');
    }

    function reCountUnits(val, $row) {
        var catId = $row.attr('data-category-id')
          , servId = $row.attr('data-service-id')
          , subservice = services[catId].service[servId].subservice
          , sum = 0
          , sumDay = 0
          ;

        var leftRow = $('.gustavs__calc__service__body').find('.gustavs__calc__service__subcategory[data-category-id='+ catId +'][data-service-id='+ servId +']');
        var rightRow = $('.gustavs__calc__results__body ').find('.gustavs__calc__results__category[data-category-id='+ catId +'][data-service-id='+ servId +']');

        for (var item in subservice) {
            var $item = subservice[item];
            rightRow.find('.gustavs__calc__results__subcategory__price').eq(item).html( $item.price_for_one * val  +' руб');
            sum += $item.price_for_one * val;
            sumDay += $item.day_to_do;
        }

        var countDay = Math.round(sumDay / 60 * val / 24);
        var diff = countDay - $row.attr('data-count-days');
        dateEndObj.setDate(dateEndObj.getDate() + diff);
        $('.gustavs__calc__finish').html(dateEndObj.toLocaleString("ru", options));

        rightRow.attr('data-count-days', countDay);
        rightRow.find('.gustavs__calc__results__category__square').val(val);
        leftRow.attr('data-count-days', countDay);



        $('.gustavs__calc__results__subcategory_sum').find('.gustavs__calc__results__subcategory__price').html(sum + 'руб');
        $('.js-work-price').html(calcSumPrice() + 'Р');
    }

    function calcDate(direction, days) {
        if (direction === 'plus') {

            dateEndObj.setDate(dateEndObj.getDate() + days);
        } else {
            dateEndObj.setDate(dateEndObj.getDate() - days);
        }

        return dateEndObj.toLocaleString("ru", options);
    }

    function calcSumPrice() {
        var total = 0;

        $('.gustavs__calc__results__subcategory_sum').find('.gustavs__calc__results__subcategory__price').each(function() {
            var itemPrice = parseInt($(this).html())

            total += itemPrice;
        })

        return total;
    }
})
