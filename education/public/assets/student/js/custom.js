
$(document).ready(function(){
    $('.chats').css('height', $(window).height() - 175);
    // Comma, not colon ----^
});
$(window).resize(function(){
    $('.chats').css('height', $(window).height()  - 175);
    // Comma, not colon ----^
});

$(function(){
    $('html:has(body.session)').addClass('h-100');
});


$(document).ready(function(){
    $('.wide .chats').css('height', $(window).height() - 357);
    // Comma, not colon ----^
});
$(window).resize(function(){
    $('.wide .chats').css('height', $(window).height()  - 357);
    // Comma, not colon ----^
});

