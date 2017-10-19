$(document).ready(function() {
    console.log('add brigade');

    var $select = $('.js-select')
      , $option = $select.find('option')
      , $peseudoSelect = $('.js-pseudo-select')
      , $input = $('.js-input')
      , $dropdownItem = $('.js-dropdown-item')
      , $addedBlock = $('.js-added-block')
      , $addedItem = $('.js-added-item')
      , $removeAddedBtn = $('.js-remove-added')
      , $commentBlock = $('.js-comment')
      , $leadInput = $('.js-brigade-lead')
      ;

    var $clientForm = $('.js-client-form')
      , $clientFormSubmit = $('.js-clien-submit')
      ;

    var $orderForm = $('.order-form')
      , $orderFields = $orderForm.find('input:not(.hidden-input), select')
      ;

    var $clientSelect = $('.js-client-select');

    function init() {
        bindEvents();
    }

    function bindEvents() {
        $peseudoSelect.on('click', function() {
            $(this).toggleClass('open');
        })

        $input.on('keyup', lifeSearch);

        $dropdownItem.on('click', function() {
            var id = $(this).data('id');

            if (!$(this).hasClass('selected')) {
                $(this).addClass('selected');


                $addedItem.each(function() {
                    if ($(this).data('id') === id) {
                        $(this).removeClass('hidden');
                        $select.find('option[value='+ id +']').attr('selected', true);
                    }
                })
            } else {
                $(this).removeClass('selected');

                $addedItem.each(function() {
                    if ($(this).data('id') === id) {
                        $(this).addClass('hidden');
                        $select.find('option[value="'+ id +'"]').attr('selected', false);
                    }
                })
            }

            if (checkCountAdded()) {
                $commentBlock.show();
            } else {
                $commentBlock.hide();
            }

            $select.trigger('change');
        })

        $removeAddedBtn.on('click', function() {
            var item = $(this).closest($addedItem)
              , id = item.data('id')
              ;

            item.addClass('hidden');

            if (item.hasClass('b-lead')) {
                item.removeClass('b-lead');
                $leadInput.val('');
            }
            $select.find('option[value="'+ id +'"]').attr('selected', false);
            $('.js-dropdown-item[data-id="'+ id +'"]').removeClass('selected');

            if (checkCountAdded()) {
                $commentBlock.show();
            } else {
                $commentBlock.hide();
            }
        });

        $clientForm.on('submit', function(e) {
            var data = getFormField();

            if ( this.checkValidity() ) {
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    url: "/admin_v2/core/formhandler/add/client.php",
                    data: data,
                    dataType: 'json',
                    success: function(e) {

                        $clientForm.find('input').closest('.form-group').removeClass('has-error');


                        if (e.status === 'error') {
                            switch (e.message) {
                                case 'email_exists':
                                    $clientForm.find('input[name=email]').closest('.form-group').addClass('has-error');
                                    break;
                            }
                        } else if (e.status === 'success') {
                            var newOption = new Option(data.first_name + '  ' + data.last_name , e.client_id, true, true);

                            $clientSelect.append(newOption).trigger('change');
                        }
                    }
                });
            }
        })

        $addedItem.on('click', function(e) {

            if (!$(e.target).hasClass('js-remove-added')) {

                if (!$(this).hasClass('b-lead')) {
                    $addedItem.removeClass('b-lead');
                    $(this).addClass('b-lead');
                    $leadInput.val($(this).data('id'));
                }

            }
        })

        $('.js-preview-btn').on('click', function(e) {
            if ( $orderForm[0].checkValidity() ) {
                e.preventDefault();
                $('.js-main-block').addClass('preview-on');
                getPreview();
            }
        })
    }

    function checkCountAdded() {
        var count = 0;

        $addedItem.each(function() {
            if (!$(this).hasClass('hidden')) {
                count++;
            }
        })

        return count > 0;

    }

    function lifeSearch() {
        var filter = $(this).val();

        $dropdownItem.each(function(){
            if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                $(this).fadeOut();

            } else {
                $(this).show();
            }
        });
    }

    function getFormField() {
        var fields = {};

        $clientForm.find('input').each(function() {
            fields[$(this).attr('name')] = $(this).val();
        })

        return fields;
    }

    function getOrderFormField() {
        var fields = {};

        $orderFields.each(function() {
            var $thisType = $(this)[0].tagName;

            switch ($thisType) {
                case 'INPUT' :
                    fields[$(this).attr('id')] = $(this).val();
                    break;
                case 'SELECT' :
                    fields[$(this).attr('id')] = $(this).val();
                    break;
            }
        })

        return fields;
    }


    function getPreview() {
        var data = getOrderFormField();

        $.ajax({
            type: "POST",
            url: "/admin_v2/core/formhandler/add/order.php?preview=true",
            data: data,
            dataType: 'json',
            success: function(e) {

                console.log(e);

                $('.js-preview-block').html(e.html);
            }
        });
    }

    init();
})