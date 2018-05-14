$(document).ready(function() {
    if(document.URL.indexOf("/edition/") >= 0) {
        $('<a href="javascript:history.back()" class="btn btn-secondary">Annuler</a>').insertBefore($('button#add_post_save'))
    }
});

$('ul.pagination li:first-child span').text('« Précédent');
$('ul.pagination li:first-child a').text('« Précédent');

$('ul.pagination li:last-child span').text('Suivant »');
$('ul.pagination li:last-child a').text('Suivant »');

$( window ).scroll(function() {
    $( "div.alert-success" ).fadeOut( "slow" );
});

var H = $('html').height();
var H_footer = $('footer').height();
var H_nav = $('nav.sticky-top').height();

var h = H - H_footer + H_nav;

$('#administration').height(h);

if (window.matchMedia("(max-width: 600px)").matches) {
    $('#administration').height(700+"px");
}