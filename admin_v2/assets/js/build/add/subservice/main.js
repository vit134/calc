$(document).ready(function() {
    console.log('add subservice');

    var $input = $('.js-input'),
        $openBtn = $('.js-open-btn'),
        $numInput = $('.js-num-input'),
        $dropdown = $('.js-dropdown'),
        $dropdownItem = $('.js-dropdown-item'),
        $selectOption = $('.js-option'),
        $controlUp = $('.js-control-up'),
        $controlDown = $('.js-control-down'),
        $addedItem = $('.js-added-item');

    function init() {
        bindEvents();
    }


    function bindEvents() {
        /*$input.on('keyup paste', function() {
            var valLenght = $(this).val().length;

            $(this).css('width', valLenght * 0.75 + 'em');
        })*/

        $openBtn.on('click', function() {
            if (!$(this).hasClass('open')) {
                $(this).addClass('open');
                $dropdown.slideDown(300);
                $input.focus();
            } else {
                $(this).removeClass('open');
                $dropdown.slideUp(300);
            }
        })

        $controlUp.on('click', function() {
            var row = $(this).closest($dropdownItem);
            changeVal(row, 'up', row.attr('data-id'))
        })

        $controlUp.on('selectstart mousedown', function() {
            return false;
        })

        $controlDown.on('selectstart mousedown', function() {
            return false;
        })

        $controlDown.on('click', function() {
            var row = $(this).closest($dropdownItem);
            changeVal(row, 'down', row.attr('data-id'))
        })

        $dropdownItem.on('click', function(e) {
            var $this = $(this);
            var id = $this.attr('data-id');
            var numVal = $this.find($numInput).val()

            if (!$(e.target).is('.js-control-up, .js-control-down, .js-num-input')) {
                if (!$this.hasClass('selected')) {
                    $selectOption.each(function() {
                        if ($(this).attr('data-id') == id) {
                            $(this).attr('selected', true);
                            $this.addClass('selected');
                        }
                    })

                    $addedItem.each(function() {
                        if ($(this).attr('data-id') == id) {
                            $(this).removeClass('hidden').find('span').html('(' + numVal + ')');
                        }
                    })
                } else {
                    $selectOption.each(function() {
                        if ($(this).attr('data-id') == id) {
                            $(this).attr('selected', false);
                            $this.removeClass('selected');
                            $this.appendTo($dropdown);
                        }
                    })

                    $addedItem.each(function() {
                        if ($(this).attr('data-id') == id) {
                            $(this).addClass('hidden');
                        }
                    })
                }
            }
        })

        $numInput.on('keyup paste', function() {
            var row = $(this).closest($dropdownItem);
            var id = row.attr('data-id');
            var val = $(this).val();

            changeVal(row, 'manual', id, val)
        })

        //прокрутка дропдаун по клику на добавленный эелемент
        /*$addedItem.on('click', function() {
            var id = $(this).attr('data-id');
            var itemPos;

            $dropdownItem.each(function() {
                if ($(this).attr('data-id') == id) {
                    itemPos = $(this).position().top;
                }
            })

            if ($dropdown.is(':visible')) {
                console.log(itemPos);
            } else {
                $dropdown.slideUp(300).scrollTop(itemPos);

            }
        })*/

        /*$(window).on('click', function(e) {
            var target = $(e.target);
            console.log(target);
            setTimeout(function() {
                if ($input.hasClass('open')) {
                    $dropdown.slideUp(300);
                    $input.removeClass('open');
                }
            }, 100)

        })*/
    }

    function changeVal($row, dir, id, val) {
        var numInput = $row.find($numInput);

        var numInputVal = numInput.val();

        if (dir === 'up') {
            numInputVal++;
            numInput.val(numInputVal);
        } else if (dir === 'down') {
            if (numInputVal >= 1) {
                numInputVal--;
                numInput.val(numInputVal);
            }
        } else {
            numInputVal = val;
            numInput.val(numInputVal);
        }

        $selectOption.each(function() {
            if ($(this).attr('data-id') == id) {
                $(this).val(id + '_' + numInputVal)
            }
        })

        $addedItem.each(function() {
            if ($(this).attr('data-id') == id) {
                $(this).find('span').html('(' + numInputVal + ')');
            }
        })
    }

    init();
})