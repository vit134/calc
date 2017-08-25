function getUrlVars() {
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for (var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}


function getSearchItems($searchBlock, $searchContainer) {
    var searchItems =[];
    var searchItem = $searchContainer.find($searchBlock);

    for (var i = 0; searchItem.length > i; i++) {
        searchItems.push(searchItem.eq(i).html())
    }

    return searchItems;
}

function showAlerts() {
    var params = getUrlVars();

    console.log(params.status);

    if (params.status == 'success') {
        alert('success');
        window.location.search = '';

    }
}