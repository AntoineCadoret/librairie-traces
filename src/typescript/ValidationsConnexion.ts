export class ValidationsConnexion {

    // ATTRIBUTS
    private objMessages: JSON;

    // -- Éléments de formulaire à valider
    private refPrenom: HTMLElement = document.getElementById('prenom');
    private refNom: HTMLElement = document.getElementById('nom');
    private refAdresseCourrielConnexion: HTMLElement = document.getElementById('adressecourrielConnexion');
    private refAdresseCourrielInscription: HTMLElement = document.getElementById('adressecourrielInscription');
    private refMotDePasseConnexion: HTMLElement = document.getElementById('motPasse');
    private refMotDePasseInscription: HTMLElement = document.getElementById('motPasse');

    private refNumTelephone: HTMLElement = document.getElementById('telephone');


    // private refAdresseFacturation: HTMLElement = document.getElementById('adresse');
    // private refVilleFacturation: HTMLElement = document.getElementById('ville');
    // private refProvinceFacturation: HTMLElement = document.getElementById('[name=province]');
    // private refCodePostal: HTMLElement = document.getElementById('codePostal');

    // Constructeur
    constructor(objetJSON: JSON,) {
        document.querySelector('form').noValidate = true;

        this.objMessages = objetJSON;
        //console.log( this.objMessages.facturation);

        this.initialiser();

    }

    private initialiser(): void {
        //Créer la référence vers élément HTML
        this.refPrenom.addEventListener('blur', this.validerPrenom.bind(this));
        this.refNom.addEventListener('blur', this.validerPrenom.bind(this));
        this.refAdresseCourrielConnexion.addEventListener('blur', this.validerCourriel.bind(this));
        this.refAdresseCourrielInscription.addEventListener('blur', this.validerCourriel.bind(this));
        this.refAdresseCourrielConnexion.addEventListener('blur', this.validerMotDePasse.bind(this));
        this.refMotDePasseInscription.addEventListener('blur', this.validerMotDePasse.bind(this));

    }

    // Méthodes de validation ****************************
    private validerPrenom(evenement): void {
        const element = evenement.currentTarget;
        if (this.verifierSiVide(element) == false) {
            this.afficherErreur(element, "vide");
        }
        else {
            const lePattern = element.pattern;
            // if (this.verifierPattern(this.refPseudo, lePattern) == true) {
            //     this.effacerErreur(element);
            //     this.arrEtapes.etape3[0]=true;
            // }
            // else {
            //     this.afficherErreur(element, 'motif');
            //}
            }

    }
    ////**Courriel
    private validerCourriel(evenement): void {
        const element = evenement.currentTarget;
        if (this.verifierSiVide(element) == false) {
            this.afficherErreur(element, "vide");
        }
        else {
            const lePattern = element.pattern;
            if (this.verifierPattern(this.refCourriel, lePattern) == true) {
                this.effacerErreur(element);
            }
            else {
                this.afficherErreur(element, "motif");
            }
        }
    }
////**Mot de passe
    private validerMotDePasse(evenement): void {
        const element = evenement.currentTarget;
        if (this.verifierSiVide(element) == false) {
            this.afficherErreur(element, "vide");
        }
        else {
            const lePattern = element.pattern;
            if (this.verifierPattern(this.refMotDePasse, lePattern) == false) {
                this.afficherErreur(element, "motif");

                const lePatternMinuscule = '/[a-z]/g';
                const lePatternMajuscule = '/[A-Z]/g';
                const lePatternNumero = '/[0-9]/g';

                console.log(element.value.match(lePatternMajuscule));
                if (element.value.length < 6 || element.value.length > 10) {
                    console.log("manque longueur");
                    this.afficherErreur(element, "size");
                }
                else {
                    if (element.value.match(lePatternMajuscule) == false) {
                        console.log("manque majusc");
                        this.afficherErreur(element, "majus");
                    }

                    if (element.value.match(lePatternNumero) == false) {
                        console.log("manque numero");
                        this.afficherErreur(element, "num");
                    }

                    if (element.value.match(lePatternMinuscule) == false) {
                        this.afficherErreur(element, "minus");
                    }
                }
                this.arrEtapes.etape3[2]=false;
            }
            else {
                this.effacerErreur(element);
                this.arrEtapes.etape3[2]=true;
            }
        }
    }
    // Méthodes utilitaires ****************************

    /**
     * @param reçoit l'élément visé
     * Retourne TRUE si la case est vide
     */
    private verifierSiVide(element): boolean {
        if (element.value == "") {
            return true;
        }
        else {
            return false;
        }


    }

    /**
     * @param reçoit l'élément visé
     * Retourne TRUE si le contenu respect le regex
     */
    private validerPattern(element, motif): boolean {
        const regexp = new RegExp(motif);
        return regexp.test(element.value);
    }

    /**
     * @param reçoit l'élément visé
     * @param reçoit le type d'erreur (cide ou motif)
     */
    private afficherErreur(element, typeErreur): void {
        element
            .closest('.ctnForm')
            .querySelector('.erreur')
            .innerHTML = "<span><svg class=\"icones icone--erreur\">\n" +
            "<use xlink:href=\"#erreur\"/>\n" +
            "</svg></span>" + this.objMessages["facturation"][element.name]["erreurs"][typeErreur];
    }


    private effacerErreur(element): void {
        element
            .closest('.ctnForm')
            .querySelector('.erreur')
            .innerHTML = "";
    }


    private montrerSucces(element) {
        element
            .closest('.ctnForm')
            .querySelector('.erreur')
            .innerHTML = "<span><svg class=\"icones icone--ok\">\n" +
            "                                    <use xlink:href=\"#succes\"/>\n" +
            " ";
    }


}