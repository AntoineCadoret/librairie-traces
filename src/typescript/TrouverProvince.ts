export class TrouverProvince {

    private strNiveau: string;
    private $codePostal: JQuery = $('#codePostal');
    private $spinner = "";

    //private $codePostal = document.querySelector('#codePostal');

    constructor(niveau = './') {
        this.strNiveau = niveau;
        /*  il ne devrait pas y avoir d'écouteur d'événement blur
            car la methode verifierDisponibilite devrait être publique
            et appelé seulement lorsque les données du champ de saisie
            ont été validés selon les règles de composition d'un pseudo
         */
        this.$codePostal.on('blur', this.interrogerBD.bind(this));
    }

    private interrogerBD(evenement): void {

        /*
        //Créer spinner par prog
        let spin_div = $(' <img hidden id="ajaxOccupe" alt="En attente" src="assets/images/retroaction.gif" width="16" height="16">');
        // Append spinner to the body
        evenement.createElement(spin_div);
        evenement.appendChild(spin_div);
        */

        //Vérification
        console.log('Je vérifie... un petit moment svp');
        //console.log(this.$codePostal.val());

        // Ajout du spinner
        document.querySelector('#ajaxOccupe').removeAttribute("hidden");

        $.ajax({
            context: this,
            url: `../inc/scripts/ajax/trouverProvince.php`,
            type: 'GET',
            // Concaténation du couple propriete=valeur qu'on doit envoyer au script php
            data: 'codePostal=' + this.$codePostal.val(),
            dataType: 'text'
        })
            .done(function (data, textStatus, jqXHR) {
                this.retournerResultat(data, textStatus, jqXHR);
                //const resultatCodePostal = this.$codePostal.val();
                //const resultatPremiereLettre = resultatCodePostal.charAt(0);
                //console.log(resultatCodePostal);
                //console.log(resultatPremiereLettre);
            })
            .fail(function (jqXHR, textStatus, error) {
                console.log(`Ici je peux afficher et gérer une ${error}`);
            })
            .always(function (dataOrJqXHR, textStatus, jQXHRorError) {
                //console.log('Ici je pourrais faire disparaitre un spinner');
                document.querySelector('#ajaxOccupe').setAttribute("hidden", "");
            });

    }


    private retournerResultat(data, textStatus, jqXHR): void {

        switch (data) {
            case '0':
                console.log(`Désolé pas de province correspondant à votre code postal`);
                break;
            case `${data}`:
                //console.log(data);

                const refFrere = document.querySelector('.noScript');
                const refParent = document.querySelector('.fieldsetAjaxProvince');
                var refProvince = document.getElementById('nomProvince');
                //console.log(refProvince);

                if (refProvince == null) {
                    const nouveauP = document.createElement('p');
                    nouveauP.setAttribute('id', 'nomProvince');
                    //nouveauP.setAttribute('name', 'nomProvince')
                    //nouveauP.setAttribute('value', `${data}`)
                    const nouveauInput = document.createElement('input');
                    nouveauInput.setAttribute('type', 'hidden');
                    nouveauInput.setAttribute('name', 'province');
                    nouveauInput.setAttribute('value',`${data}`);
                    //const donnees = data.nomProvince;
                    const leTexte = document.createTextNode(`${data}`);
                    nouveauP.appendChild(leTexte);
                    refParent.insertBefore(nouveauP, refFrere);
                    refParent.insertBefore(nouveauInput, refFrere);
                    //ou refParent.parentNode
                }
                else{
                    refProvince.innerText=`${data}`;
                }

                break;
            default:
                console.log(`Désolé pas de province correspondant à votre code postal`);
                break;
        }
    }


}
