import {AfficherCacher} from './AfficherCacher';
import {Autocompletion} from './Autocompletion';

import {AjoutAuPanier} from "./AjoutAuPanier";
import {ValiderCourriel} from "./ValiderCourriel";
import {TrouverProvince} from "./TrouverProvince";
import {ValidationsFacturation} from "./ValidationsFacturation";


customElements.define( 'afficher-cacher', AfficherCacher);

// Pour les onglets
import {HowtoTabs} from "HowtoTabs";
import {HowtoTabsConnexion} from "./HowtoTabs-connexion";
import {HowtoTab} from "HowtoTab";
import {HowtoPanel} from "HowtoPanel";


customElements.define('howto-tabs', HowtoTabs);
customElements.define('howto-tabs2', HowtoTabsConnexion);
customElements.define('howto-tab', HowtoTab);
customElements.define('howto-panel', HowtoPanel);

new AjoutAuPanier(strNiveau);

new ValiderCourriel(strNiveau);

new TrouverProvince(strNiveau);

new Autocompletion();


// requête ajax pour obtenir le fichier JSON (selon la démo)
$.ajax({
    type: "GET",
    url:  strNiveau + "inc/scripts/ajax/obtenirJSON.php",
    datatype:JSON
})
    .done(function(data, textStatus, jqXHR){
        new ValidationsFacturation(data);
        //console.info('done: ' + textStatus);
    })
    .fail(function (resultat, statut, erreur) {
        //console.info('fail: ' + statut);
    })
    .always(function (resultat, statut) {
       // console.info('always: ' + statut);
    });

