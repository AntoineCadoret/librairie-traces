/**
 * L'ajout au panier doit permettre d'afficher une rétroaction
 * "Vous venez d'ajouter à votre panier: "
 * et les infos suivantes:
 * Le nom ou la vignette du produit fraichement ajouté
 * Le nombre d’articles total dans le panier
 * Le sous-total de tous les articles
 * Lien «Voir le panier» navigue vers la page panier.
 * Lien «Passer la commande» navigue vers la page de connexion/création de compte.
 *
 * Ce module comporte:
 *** des styles css (module .ctrlPanier)
 *** une classe typescript AjoutAuPanier
 *** un script php pour le ajax -> inc/scripts/ajax/maj_Panier.php
 *** un script php pour la version sans javascript -> au début de index.php
 *** le HTML / BEM du module ctrlPanier lignes 108-111 de index.php
 *
 * JavaScript et accessibilité
 * @todo pour l'accessibilité ajouter aria-live sur le div de l'alerte
 * @todo pour l'accessibilité amener le focus dans la rétroaction, sur le lien Voir mon Panier
 * @todo ajouter un spinner
 * @todo ajouter le texte "Fermer" dans le bouton X mais seulement pour les lecteurs d'écran
 * @todo (FACULTATIF) traduire en js natif sauf pour l'objet AJAX
 *
 * PHP
 * @todo Transposer l'exemple dans Traces en utilisant adéquatement les templates Savant3
 * @todo Faire véritablement l'ajout au panier...
 */

export class AjoutAuPanier {

    // Attributs
    private niveau: string;
    $cibleDuSpinner; // le .btnAjouter contextuel au data-isbn="isbn"
    private $btnAjoutPanier: JQuery = $('.btnAjouter');

    public constructor(niveau: string) {

        //console.log("allo le niveau envoyé =" + niveau);

        this.niveau = niveau;

        this.$btnAjoutPanier.on('click', this.gererClickBtnAjouter.bind(this));

    }

    private gererClickBtnAjouter(e): void {

        // Empêcher la soumission du formulaire
        e.preventDefault();

        // Préparer les données à envoyer (relever le isbn dans l'attribut data-isbn)
        const article = $(".isbnSent");
        const selectQuantite = $("#quantiteLivre").val();
        const imageLivre = $('.imgCouverture').attr('src');
        const titre = $("#titre").text();
        //console.log(selectQuantite);
        //console.log(imageLivre);
        const dataISBN = `${article.attr('data-isbn')}`;
        const dataQuant = `${selectQuantite}`;
        const dataImg = imageLivre;
        const dataTitre = titre;

        //console.log(dataTitre);

        // $cibleDuSpinner = currentTarget;
        // demarrerAnimSpinner($cibleDuSpinner);

        // Si il a plus d'un item
        if(selectQuantite > 0 ){
            this.demanderAJAX(dataISBN, dataQuant, dataImg, dataTitre);
        }

    }

    // Méthodes de gestion d'événement asynchrone (AJAX)
    private demanderAJAX(dataISBN, dataQuant, dataImg, dataTitre): void {

        $.ajax({
            context: this,
            url: `${this.niveau}inc/scripts/ajax/maj_Panier.php`,
            type: 'GET',
            data: {"isbn": dataISBN, "quantite": dataQuant, "imageLivre": dataImg, "titreLivre": dataTitre},
            dataType: "JSON"
        })
            .done(function (data, textStatus, jqXHR) {
                this.retournerResultat(data, textStatus, jqXHR);
            })
            .fail(function (jqXHR, textStatus, error, data) {
                this.retournerErreur(jqXHR, textStatus, error, data);
            })
            .always(function (dataOrJqXHR, textStatus, jQXHRorError) {

            });
    }

    private retournerResultat(data, textStatus, jqXHR): void {

        // const donnees = JSON.parse(data);
        const donnees = data;

        // utiliser le idProduit pour récupérer les données du produit dans le HTML
        const $titre = $("#titre").text();
        //const titre = $article.find($article).text();
        //console.log('LARTICLE: ' + $titre);

        // MISE À JOUR DES DONNÉES DANS LA PAGE WEB
        // d'abord au niveau de l'icône du panier
        $('.ctrlPanier__nombreItems').text(`${donnees.nombreArticles}`);

        // ensuite, créer la rétroaction
        if ($('.ctrlPanier__retroaction')) {
            // au cas ou l'utilisateur clic à répétition sans jamais fermer la rétro
            $('.ctrlPanier__X, .ctrlPanier__retroaction').remove();
        }
        $('.ctrlPanier')
            .append(`<div class="divRetroaction"><div class="ctrlPanier__retroaction"> </div>`);
        $('.ctrlPanier__retroaction')
            .hide()
            .append(`
                <button type="button" class="ctrlPanier__X btnX_ajax">X</button>
                <img class="retroImgLivre livreSansCouverture" src ="${donnees.imageLivre}">
                <p class="pNoir">Vous venez d'ajouter à votre panier: (${donnees.nombreArticlesAjouter})</p>
                <p><cite>${donnees.titre}</cite></p>
                <p><span class="pNoir">Sous-total  </span> (${donnees.nombreArticles} articles) : ${donnees.sousTotal}$</p> 
                <p class="lienBouton" ><a class="a" href="../transaction/panier.php">Voir mon panier</a></p>
                <p class="lienBouton"><a class="a" href="../connexion.php">Passer la commande</a></p>
                </div>
            `);

        $('.ctrlPanier__retroaction').slideDown('slow');

        /*
        $('.ctrlPanier__titre')
            .append(`   <button type="button" class="ctrlPanier__X btnX_ajax">X</button>`);
        */

        // ajouter un écouteur d'événement sur le bouton de fermeture de la rétroaction
        $('.ctrlPanier__X').on('click', this.fermerRetroPanier);

        // placer le focus dans le div de l'alerte
        // sur le bouton fermer ou sur le lien voir le panier
        $('.ctrlPanier__X').focus();

    }

    private retournerErreur(jqXHR, textStatus, error, data): void {
        if (jqXHR.status == 404) {
            console.info('Il semble que le chemin ou le nom du script est erroné.');
        }
        else {
            // Pour déboguer, tracer les autres status d'erreur
            console.info(`info retourner erreur ${jqXHR.status}, ${textStatus}, ${error}`);
        }
    }


    /**************************************************
     * Méthodes utilitaires
     *************************/

    private demarrerAnimSpinner($cibleDuSpinner): void {

    }

    private fermerRetroPanier(): void {
        $('.ctrlPanier__retroaction').slideUp('slow', function () {
            $('.ctrlPanier__X').fadeOut('fast', function () {
                $('.ctrlPanier__X, .ctrlPanier__retroaction').remove();
            });
        });
    }

}