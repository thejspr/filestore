function search(url) {
    var query = $('#search-field').val;
    window.location = url + "&query=" + query
}