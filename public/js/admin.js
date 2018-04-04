$(document).ready(function() {
    if(document.URL.indexOf("/edit/") >= 0) {
        $('<a href="javascript:history.back()" class="btn btn-danger">Annuler</a>').insertBefore($('button#add_post_save'))
    }
});

// $( "#add_post_save" ).click(function() {
//     $( ".alert" ).fadeOut( "slow", function() {
//         // Animation complete.
//     });
// });