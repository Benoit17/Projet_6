$(function(){
    var H = $('header').width();
    var h = H/2
    $('header>div:first-child').width(h);
    $('header>div:first-child').height(h);

    $( window ).resize(function() {
        var H = $('header').width();
        var h = H/2
        $('header>div:first-child').width(h);
        $('header>div:first-child').height(h);
    });
});