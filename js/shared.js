function alternateRowColor(selector) {
    $(selector+':even').each(function(){
        $(this).css("background-color", "#FFF")
    });
    $(selector+':odd').each(function(){
        $(this).css("background-color", "#E6F2FF")
    });

}

setTimeout("$('.success').fadeOut('slow');",5000);
