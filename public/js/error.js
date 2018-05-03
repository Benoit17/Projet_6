$(function(){
    var H = $('section div:first-child').width();
    $('section div:first-child').height(H);

    $( window ).resize(function() {
        var H = $( "section div:first-child" ).width();
        $('section div:first-child').height(H);
    });
});