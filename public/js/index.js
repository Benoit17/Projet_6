$(function(){
//Enlève la validation des erreurs par le navigateur
    $('form[name="contact"]').attr('novalidate', 'novalidate');
});

//Ouvre les onglets correspondant en cas d'erreur
$(document).ready(function () {
    if ($("input").hasClass('is-invalid')) {
        self.location.href='#contact'
    }
});