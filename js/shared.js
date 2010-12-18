// change row color on tables
function alternateRowColor(selector) {
    var bg_color = "#FFF";
    var alt_bg_color = "#aae2ff";
    
    var cookie = $.cookie('fs_bg_cookie');
    if (cookie != undefined) {
        bg_color = cookie == 1 ? "#36393D" : "#FFF";
        alt_bg_color = cookie == 1 ? "#4f5359" : "#aae2ff";
    }
    
    $(selector+' tr:even :not(th)').each(function(){
        $(this).css("background-color", alt_bg_color)
    });
    
    $(selector+' tr:odd :not(th)').each(function(){
        $(this).css("background-color", bg_color)
    });
}

function toggleTheme() {
    var bg_cookie = $.cookie('fs_bg_cookie');
    
    if (bg_cookie != undefined) {
        var newTheme;
        if (bg_cookie == 0)
            newTheme = 1;
        else
            newTheme = 0
            
        changeTheme(newTheme);
    }
}

function changeTheme(theme) {
    if (theme == 1) {
        $('body').css('background-color','#36393D');
        $('body, h1, h2, h3, #logo-first').css('color','#fff');
        $('#content h1').css('border-color', '#CCC');
        $('#footer').css('border-color','#CCC');
        $('body a').css('color', '#4ca1cc');
    } else {
        $('body').css('background','#FFF');
        $('body, h1, h2, h3, #logo-first').css('color','#000');
        $('#content h1').css('border-color', '#000');
        $('#footer').css('border-color','#000');
        $('body a').css('color', '#347498');
    }
    $.cookie('fs_bg_cookie', theme);  
    alternateRowColor('.item-list, shares');
}

// run when document is loaded.
$(document).ready(function(){
    // get theme cookie value
    var theme = $.cookie('fs_bg_cookie');
    
    // change theme if cookie value is 1 (dark)
    if (theme == 1)
        changeTheme(theme);

    // Modernizr and placeholder alternative
    // if placeholder isn't supported:
    if (!Modernizr.input.placeholder){
      // use a input hint script
      $('#search-field').hint();
    }
    
    // timeout for flash messages.
    setTimeout("$('.success').fadeOut('slow');",5000);
});
