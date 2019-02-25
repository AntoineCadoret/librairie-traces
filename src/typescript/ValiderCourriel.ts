export class ValiderCourriel {
    private strNiveau:string;
    private $courriel:JQuery = $('#adressecourrielInscription');

    constructor(niveau = '../../'){
        this.strNiveau = niveau;
        console.log(this.$courriel);
        this.$courriel.on('blur', this.verifierDisponibilite.bind(this));
    }


    private verifierDisponibilite(evenement):void{
        console.log('Je vérifie... un petit moment svp');
        // document.getElementById('ajaxOccupe').className = "";

        $.ajax({
            context: this,
            url : `${this.strNiveau}inc/scripts/ajax/getCourriel.php`,
            type : 'GET',
            // Concaténation du couple propriete=valeur qu'on doit envoyer au script php
            data : 'courriel_client=' + this.$courriel.val(),
            dataType : 'text'
        })
            .done(function(data, textStatus, jqXHR){
                this.retournerResultat(data, textStatus, jqXHR);
            })
            .fail(function(jqXHR, textStatus, error){
                 console.log(`Ici je peux afficher et gérer une ${error}`);
            })
            .always(function(dataOrJqXHR, textStatus, jQXHRorError){
                console.log('Ici je pourrais faire disparaitre un spinner');
            });
    }

    private retournerResultat(data, textStatus, jqXHR):void{
        switch (data){
            case '-1':
                console.log(`Hum, avez-vous entré un courriel?`);
                break;
            case '0':
                console.log(`Le courriel ${this.$courriel.val()} est disponible!`);
                break;
            default:
                console.log(`Désolé... le courriel ${data} existe déjà! Avez vous oublié votre mot de passe?`);
                break;
        }
    }

}