function getXMLHTTPRequest() {
    if (window.XMLHttpRequest) {
        return new XMLHttpRequest();
    } else {
        return new ActiveXObject("Microsoft.XMLHTTP");
    }
}

function callAjax(url, inner) {
    // TODO 4: Lengkapilah fungsi callAjax()
    var xmlhttp = getXMLHTTPRequest();
    xmlhttp.open('GET', url, true);
    // document.getElementById(inner).innerHTML = '<img src="sabar.png">';
    xmlhttp.onreadystatechange = function() {
        if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200)) {
            response = JSON.parse(xmlhttp.responseText);
            console.log(response);
            var table = document.getElementById(inner);

            data.forEach(function(object) {
                var tr = document.createElement('tr');
                tr.innerHTML = '<td>' + object.isbn + '</td>' +
                '<td>' + object.judul + '</td>' +
                '<td>' + object.BALANCE + '</td>' +
                '<td>' + object.DATE + '</td>';
                table.appendChild(tr);
            });
        }
    }
    xmlhttp.send(null);
}

function get_search_result(search) {
    var inner = 'search_result';
    var url = 'buku/search?s=' + search;

    callAjax(url, inner);
}