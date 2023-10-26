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
            var table = $("#table tbody");
            $.each(data, function(idx, elem){
                table.append("<tr><td>"+elem.username+"</td><td>"+elem.name+"</td><td>"+elem.lastname+"</td></tr>");
            });
            document.getElementById(inner).innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.send(null);
}

function get_search_result(search) {
    var inner = 'search_result';
    var url = 'buku/search.php?s=' + search;

    callAjax(url, inner);
}