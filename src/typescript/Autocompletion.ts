/**
 * Autocompletion
 *
 * @todo compléter le else if (e.keyCode == this.keyCode.UP) lignes 103 et +
 * @todo ajouter aria-live sur autocompletion__data
 *
 * Module BEM autocompletion
 * form#frecherche
 *   div.autocompletion
 *     input.autocompletion__motsCles
 *     div.autocompletion__data
 *       ul>li*             // liste de suggestions ajoutées dynamiquement
 *     input[type=submit]#btnSubmitRecherche
 *     span.autocompletion__indicateurDeProgres  <-- spinner!
 */

export class Autocompletion {

    // Attributs
    $input = $('.autocompletion__motsCles');
    noLi = -1;
    keyCode = {
        ENTER: 13,
        PAGE_UP: 33,
        PAGE_DOWN: 34,
        END: 35,
        HOME: 36,
        LEFT: 37,
        UP: 38,
        RIGHT: 39,
        DOWN: 40
    };

    spinner = `<span class="autocompletion__indicateurDeProgres"> 
             <img src="images/ajax-loader.gif" alt="Processus en cours..."> 
             </span>`;


    public constructor() {
        this.$input.on('blur', this.effacerSuggestions.bind(this));
        this.$input.on('keyup', this.demanderAjax.bind(this));
        this.$input.on('keypress', this.empecherSoumission.bind(this));
    }

    /**
     * Si focus dans le champ mot-clé,
     *   désactiver la soumission du formulaire avec la touche enter
     *   car elle doit pouvoir servir à sélectionner un li
     * @param {Event} e - keypress
     */
    private empecherSoumission(e): void {
        if (e.keyCode == this.keyCode.ENTER) {  //13
            e.preventDefault();
        }
    }

    /**
     * À partir des données saisies par l'usager
     * faire une requête à la BD pour proposer une liste de suggestions
     * @param {Event} e - keyup
     */
    private demanderAjax(e): void {

        if (this.$input.val() !== "" &&
            e.keyCode !== this.keyCode.DOWN &&
            e.keyCode !== this.keyCode.UP &&
            e.keyCode !== this.keyCode.ENTER) {

            const donneesUsager = this.$input.val();
            const donnees = 'data=' + donneesUsager;

            this.afficherIndicateurProgres();
            $.ajax({
                context: this,
                type: "GET",
                url: "inc/scripts/ajax/serveur_autocompletion.php",
                data: donnees
            })
                .done(function (data, textStatus, jqXHR) {
                    //S'il y a déjà un résultat, enlever l'ancienne fonction sélection
                    if ($('.autocompletion__data')) {
                        $('.autocompletion__data').remove();
                    }
                    this.retournerResultat(data, textStatus, jqXHR);
                })
                .fail(function (resultat, statut, erreur) {
                    console.info('error: ' + statut);
                })
                .always(function (resultat, statut) {
                    console.info('complete: ' + statut);
                    if ($('.autocompletion__indicateurDeProgres')) {
                        $('.autocompletion__indicateurDeProgres').remove();
                    }
                });
        }
        // flèche vers le bas
        else if (e.keyCode == this.keyCode.DOWN) {     //40
            //Ajouter une condition si on est au dernier

            this.noLi++;
            $('.autocompletion__data li')
                .removeClass()
                .addClass("repos");
            $($('.autocompletion__data li')[this.noLi])
                .removeClass()
                .addClass("selected");
        }
        // flèche vers le haut
        else if (e.keyCode == this.keyCode.UP) {     //38
            //Ajouter une condition si on est au premier
            this.noLi--;
            $('.autocompletion__data li')
                .removeClass()
                .addClass("repos");
            $($('.autocompletion__data li')[this.noLi])
                .removeClass()
                .addClass("selected");
        }
        // touche enter
        else if (e.keyCode == this.keyCode.ENTER) {     //13
            this.$input.val($('.autocompletion__data li')[this.noLi].innerText);
            this.effacerSuggestions();
        }
    }

    private retournerResultat(code_html, statut, jqXHR) {
        console.info('success: ' + statut);
        $('#btnSubmitRecherche').before(code_html);
        $('.autocompletion__data li').on('click', this.cliquerLi.bind(this));
    }

    private cliquerLi(e): void {
        console.info('cliquerLi');
        this.$input.val($(e.currentTarget).text());
    }

    private effacerSuggestions(): void {
        this.noLi = -1;
        if ($('.autocompletion__data')) {
            setTimeout("$('.autocompletion__data').remove()", 200);
        }
    }

    private afficherIndicateurProgres(): void {
        if ($('.autocompletion__indicateurDeProgres')) {
            $('.autocompletion__indicateurDeProgres').remove();
        }
        $('#btnSubmitRecherche').after(this.spinner);
    }

}