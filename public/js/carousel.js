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

    var Hmap = $('#map').width();
    $('#map').height(Hmap);

    $( window ).resize(function() {
        var Hmap = $( "#map" ).width();
        $('#map').height(Hmap);
    });
});