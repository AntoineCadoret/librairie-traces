export class ValidationsFacturation {

    // ATTRIBUTS
    private objMessages: JSON;

    // -- Éléments de formulaire à valider
    private refModePaiement: Array<HTMLElement> = Array.apply(null, document.querySelectorAll('[name=modePaiement]'));
    private refNumCarte: HTMLElement = document.getElementById('numCarte');
    private refNomTitulaire: HTMLElement = document.getElementById('nomTitulaire');
    private refDateExpiration: HTMLElement = document.getElementById('dateExpiration');
    private refNumSecurite: HTMLElement = document.getElementById('numSecurite');

    private refPrenomFacturation: HTMLElement = document.getElementById('prenom');
    private refNomFacturation: HTMLElement = document.getElementById('nom');
    private refAdresseFacturation: HTMLElement = document.getElementById('adresse');
    private refVilleFacturation: HTMLElement = document.getElementById('ville');
    private refCodePostal: HTMLElement = document.getElementById('codePostal');

    private refCourriel: HTMLElement = document.getElementById('courriel');
    private refNumTelephone: HTMLElement = document.getElementById('numTelephone');


    // Constructeur
    constructor(objetJSON: JSON,) {

        this.objMessages = objetJSON;
        //console.log( this.objMessages.facturation);

        this.initialiser();

    }

    private initialiser(): void {
        //Créer la référence vers élément HTML
        this.refModePaiement.forEach(btnRadio => btnRadio.addEventListener('blur', this.validerModePaiement.bind(this)));
        this.refNumCarte.addEventListener('blur', this.validerNumCarte.bind(this));
        this.refNomTitulaire.addEventListener('blur', this.validerNomTitulaire.bind(this));
        this.refDateExpiration.addEventListener('blur', this.validerNomTitulaire.bind(this));
        this.refNumSecurite.addEventListener('blur', this.validerNumSecurite.bind(this));

        this.refPrenomFacturation.addEventListener('blur', this.validerPrenomFacturation.bind(this));
        this.refNomFacturation.addEventListener('blur', this.validerNomFacturation.bind(this));
        this.refAdresseFacturation.addEventListener('blur', this.validerAdresseFacturation.bind(this));
        this.refVilleFacturation.addEventListener('blur', this.validerVilleFacturation.bind(this))
        this.refCodePostal.addEventListener('blur', this.validerCodePostal.bind(this));

        this.refCourriel.addEventListener('blur', this.validerCourriel.bind(this));
        this.refNumTelephone.addEventListener('blur', this.validerNumTelephone.bind(this));
    }

    // Méthodes de validation ****************************
    private validerModePaiement(evenement): void {
        const element = evenement.currentTarget;
        console.log('valider paiement:' + element);
        if (element.checked == false) {
            this.afficherErreur(element, "vide");
        }
        else {
            this.effacerErreur(element);
            //Afficher svg ok
            this.montrerSucces(element);
        }
    }

    private validerNumCarte(evenement) : void{
        const element = evenement.currentTarget;
        //Vérifier si vide
        const estVide = this.verifierSiVide(element);
        const lePattern = element.pattern;

        if(estVide == true){
            this.afficherErreur(element, "vide");
        }
        else{
            //sinon vérifié si conforme aux exigences (pattern)
            const patternEstValide = this.validerPattern(element, lePattern);
            if (patternEstValide == false) {
                this.afficherErreur(element, "motif");
            }else {
                this.effacerErreur(element);
                //Afficher svg ok
                this.montrerSucces(element);
            }
        }
    }

    private validerNomTitulaire(evenement) : void{
        const element = evenement.currentTarget;
        //Vérifier si vide
        const estVide = this.verifierSiVide(element);
        const lePattern = element.pattern;

        if(estVide == true){
            this.afficherErreur(element, "vide");
        }
        else{
            //sinon vérifié si conforme aux exigences (pattern)
            const patternEstValide = this.validerPattern(element, lePattern);
            if (patternEstValide == false) {
                this.afficherErreur(element, "motif");
            }
            else {
                this.effacerErreur(element);
                //Afficher svg ok
                this.montrerSucces(element);
            }
        }
    }

    private validerDateExpiration(evenement) : void{
        const element = evenement.currentTarget;
        //Vérifier si vide
        const estVide = this.verifierSiVide(element);
        const lePattern = element.pattern;

        if(estVide == true){
            this.afficherErreur(element, "vide");
        }
        else{
            //sinon vérifié si conforme aux exigences (pattern)
            const patternEstValide = this.validerPattern(element, lePattern);
            if (patternEstValide == false) {
                this.afficherErreur(element, "motif");
            }
            else {
                this.effacerErreur(element);
                //Afficher svg ok
                this.montrerSucces(element);
            }
        }
    }

    private validerNumSecurite(evenement) :void{
        const element = evenement.currentTarget;
        //Vérifier si vide
        const estVide = this.verifierSiVide(element);
        const lePattern = element.pattern;

        if(estVide == true){
            this.afficherErreur(element, "vide");
        }
        else{
            //sinon vérifié si conforme aux exigences (pattern)
            const patternEstValide = this.validerPattern(element, lePattern);
            if (patternEstValide == false) {
                this.afficherErreur(element, "motif");
            }
            else {
                this.effacerErreur(element);
                //Afficher svg ok
                this.montrerSucces(element);
            }
        }
    }

    private validerNomFacturation(evenement):void{
        const element = evenement.currentTarget;
        //Vérifier si vide
        const estVide = this.verifierSiVide(element);
        const lePattern = element.pattern;

        if(estVide == true){
            this.afficherErreur(element, "vide");
        }
        else{
            //sinon vérifié si conforme aux exigences (pattern)
            const patternEstValide = this.validerPattern(element, lePattern);
            if (patternEstValide == false) {
                this.afficherErreur(element, "motif");
            }
            else {
                this.effacerErreur(element);
                //Afficher svg ok
                this.montrerSucces(element);
            }
        }
    }

    private validerPrenomFacturation(evenement):void{
        const element = evenement.currentTarget;
        //Vérifier si vide
        const estVide = this.verifierSiVide(element);
        const lePattern = element.pattern;

        if(estVide == true){
            this.afficherErreur(element, "vide");
        }
        else{
            //sinon vérifié si conforme aux exigences (pattern)
            const patternEstValide = this.validerPattern(element, lePattern);
            if (patternEstValide == false) {
                this.afficherErreur(element, "motif");
            }
            else {
                this.effacerErreur(element);
                //Afficher svg ok
                this.montrerSucces(element);
            }
        }
    }

    private validerAdresseFacturation(evenement):void{
        const element = evenement.currentTarget;
        //Vérifier si vide
        const estVide = this.verifierSiVide(element);
        const lePattern = element.pattern;

        if(estVide == true){
            this.afficherErreur(element, "vide");
        }
        else{
            //sinon vérifié si conforme aux exigences (pattern)
            const patternEstValide = this.validerPattern(element, lePattern);
            if (patternEstValide == false) {
                this.afficherErreur(element, "motif");
            }
            else {
                this.effacerErreur(element);
                //Afficher svg ok
                this.montrerSucces(element);
            }
        }
    }

    private validerVilleFacturation(evenement) :void {
        const element = evenement.currentTarget;
        //Vérifier si vide
        const estVide = this.verifierSiVide(element);
        const lePattern = element.pattern;

        if(estVide == true){
            this.afficherErreur(element, "vide");
        }
        else{
            //sinon vérifié si conforme aux exigences (pattern)
            const patternEstValide = this.validerPattern(element, lePattern);
            if (patternEstValide == false) {
                this.afficherErreur(element, "motif");
            }
            else {
                this.effacerErreur(element);
                //Afficher svg ok
                this.montrerSucces(element);
            }
        }
    }

    private validerCodePostal(evenement) :void {
        const element = evenement.currentTarget;
        //Vérifier si vide
        const estVide = this.verifierSiVide(element);
        const lePattern = element.pattern;

        if(estVide == true){
            this.afficherErreur(element, "vide");
        }
        else{
            //sinon vérifié si conforme aux exigences (pattern)
            const patternEstValide = this.validerPattern(element, lePattern);
            if (patternEstValide == false) {
                this.afficherErreur(element, "motif");
            }
            else {
                this.effacerErreur(element);
                //Afficher svg ok
                this.montrerSucces(element);
            }
        }
    }

    private validerCourriel(evenement) :void {
        const element = evenement.currentTarget;
        //Vérifier si vide
        const estVide = this.verifierSiVide(element);
        const lePattern = element.pattern;

        if(estVide == true){
            this.afficherErreur(element, "vide");
        }
        else{
            //sinon vérifié si conforme aux exigences (pattern)
            const patternEstValide = this.validerPattern(element, lePattern);
            if (patternEstValide == false) {
                this.afficherErreur(element, "motif");
            }
            else {
                this.effacerErreur(element);
                //Afficher svg ok
                this.montrerSucces(element);
            }
        }
    }

    private validerNumTelephone(evenement) :void{
        const element = evenement.currentTarget;
        //Vérifier si vide
        const estVide = this.verifierSiVide(element);
        const lePattern = element.pattern;

        if(estVide == true){
            this.afficherErreur(element, "vide");
        }
        else{
            //sinon vérifié si conforme aux exigences (pattern)
            const patternEstValide = this.validerPattern(element, lePattern);
            if (patternEstValide == false) {
                this.afficherErreur(element, "motif");
            }
            else {
                this.effacerErreur(element);
                //Afficher svg ok
                this.montrerSucces(element);
            }
        }
    }


    //Méthodes utilitaire ********************************
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
            "                                    <use xlink:href=\"#erreur                    \"/>\n" +
            "                                </svg></span>" + this.objMessages["facturation"][element.name]["erreurs"][typeErreur];
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