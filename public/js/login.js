$(document).ready(function () {
    // CHANGER ROLE
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
                                location.reload(true);
                            },
                            error: function (jqxhr) {
                                //En cas d'erreur on affiche un message d'erreur
                                if(jqxhr.status === 500) {
                                    $('.flash-msg-cnx').replaceWith('<div class="alert alert-danger justify-content-center flash-msg-cnx">Compte désactivé, contactez l\'administrateur.</div>');
                                }else {
                                    $('.flash-msg-cnx').replaceWith(jqxhr.responseText);
                                }
                            }
                        })
                    })

                },
                error: function() {
                    // Si la modale ne s'affiche pas un message d'erreur apparait
                    addFlashMsg('danger', "Une erreur est survenue")
                }
            });
        });
    }
});
