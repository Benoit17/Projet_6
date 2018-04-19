$(document).ready(function () {
    // CONNEXION
    login();

    // fonction permettant de se connecter
    function login() {
        //On affiche la modale en cliquant sur le bouton connexion
        $('.btn-connexion-modal').on('click', function edit(e){
            e.preventDefault();
            //Notre objet modale
            var $a = $(this);
            //L'url de la modale
            var url = $a.attr('href');
            $.ajax({
                type: 'GET',
                url: url,
                success: function(data) {
                    // ajoute la modale
                    $('body').prepend(data);
                    // affiche la modale
                    $('#connexionModal').modal('show');
                    // en cas de fermeture  de la modale sans modification
                    $('#connexionModal').on('hidden.bs.modal', function (e) {
                        // supprime la modale
                        $('#connexionModal').replaceWith('');
                    });
                    // A la soumission du formulaire après avoir cliqué sur le bouton submit, on se sert d'ajax pour envoyer le formulaire
                    $('#connexion-form').on('submit', function(e){
                        e.preventDefault();
                        var $form = $(this);
                        url = $a.attr('href');
                        $.ajax({
                            type: 'POST',
                            url: url,
                            data: $form.serialize(),
                            success: function () {
                                //En cas de succes on recharge la page
                                location.href="http://localhost/projet_6/public/index.php/admin";
                            },
                            error: function (jqxhr) {
                                //En cas d'erreur on affiche un message d'erreur
                                $('.flash-msg-cnx').replaceWith(jqxhr.responseText);
                            }
                        })
                    })
                }
            });
        });
    }
});