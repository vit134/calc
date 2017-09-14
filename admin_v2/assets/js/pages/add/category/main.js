$(document).ready(function() {
    console.log('add category');

    var $input = $('.js-input'),
        $numInput = $('.js-num-input'),
        $dropdown = $('.js-dropdown'),
        $dropdownItem = $('.js-dropdown-item'),
        $selectOption = $('.js-option'),
        $controlUp = $('.js-control-up'),
        $controlDown = $('.js-control-down');

    function init() {
        bindEvents();
    }


    function bindEvents() {
        $input.on('focus', function() {
            $(this).addClass('open');
            $dropdown.slideDown(300);
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

            if (!$(e.target).is('.js-control-up, .js-control-down, .js-num-input')) {
                if (!$this.hasClass('selected')) {
                    $selectOption.each(function() {
                        if ($(this).attr('data-id') == id) {
                            $(this).attr('selected', true);
                            $this.addClass('selected');
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
                }
            }
        })

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

    function changeVal($row, dir, id) {
        var numInput = $row.find($numInput);

        var numInputVal = numInput.val();

        if (dir == 'up') {
            numInputVal++;
            numInput.val(numInputVal);
        } else {
            if (numInputVal >= 1) {
                numInputVal--;
                numInput.val(numInputVal);
            }
        }

        $selectOption.each(function() {
            if ($(this).attr('data-id') == id) {
                $(this).val(id + '_' + numInputVal)
            }
        })
    }

    init();
})