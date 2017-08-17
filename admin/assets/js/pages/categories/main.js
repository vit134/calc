$(document).ready(function() {
    console.log('categories');

    var searchCont = $('.js-pinterest-container')
      , searchItem = $('.category__item__title').find('a')
      , liveSearchList = []
      ;


    if (getUrlVars()['status'] && getUrlVars()['status'] !== '') {
        var status = getUrlVars()['status'];
        if (status === 'success') {
            alert('success');
            window.location = '/admin/categories/';
        }
    }


    var liveSearchList = getSearchItems(searchItem, searchCont);

})