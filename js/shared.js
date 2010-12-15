// change row color on tables
function alternateRowColor(selector) {
        $(selector+' tr:even :not(th)').each(function(){
            $(this).css("background-color", "#E6F2FF")
        });
        
        $(selector+' tr:odd :not(th)').each(function(){
            $(this).css("background-color", "#FFF")
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