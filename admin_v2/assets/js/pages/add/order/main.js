$(document).ready(function() {
    var $select = $('.js-select')
      , $option = $select.find('option')
      , $peseudoSelect = $('.js-pseudo-select')
      , $input = $('.js-input')
      , $dropdownItem = $('.js-dropdown-item')
      , $addedBlock = $('.js-added-block')
      , $addedItem = $('.js-added-item')
      , $removeAddedBtn = $('.js-remove-added')
      ;

    var $clientForm = $('.js-client-form')
      , $clientFormSubmit = $('.js-clien-submit')
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
        })

        $removeAddedBtn.on('click', function() {
            var item = $(this).closest($addedItem)
              , id = item.data('id')
              ;

            item.addClass('hidden');
            $select.find('option[value="'+ id +'"]').attr('selected', false);
            $('.js-dropdown-item[data-id="'+ id +'"]').removeClass('selected');
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
                        console.log(e);

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
                            //'<option value="'+ e.client_id +'" selected="selected">' + data.first_name + '  ' + data.last_name + '</option>'
                        }
                    }
                });
            }
        })
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

    init();
})