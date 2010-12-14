// change row color on tables
function alternateRowColor(selector) {
    $(selector+':even').each(function(){
        $(this).css("background-color", "#FFF")
    });
    $(selector+':odd').each(function(){
        $(this).css("background-color", "#E6F2FF")
    });

}

// timeout for flash messages.
setTimeout("$('.success').fadeOut('slow');",5000);

// Modernizr and placeholder alternative
// if placeholder isn't supported:
$(document).ready(function(){
    if (!Modernizr.input.placeholder){
      // use a input hint script
      $('#search-field').hint();
    }
});