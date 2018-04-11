$(function(){
    $('.carousel-item:first-child').attr('class', 'carousel-item active');

    var H = $('header').width();
    $('div.carousel-item').height(H);

    var h = H/2;
    $('.arrow').css('bottom', h);

    $( window ).resize(function() {
        var H = $( "header" ).width();
        $('div.carousel-item').height(H);

        var h = H/2;
        $('.arrow').css('bottom', h);
    });
});


