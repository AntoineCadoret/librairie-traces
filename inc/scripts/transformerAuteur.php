<?php
/**
 * @auteur Michaël Croteau <mickeycroteau@gmail.com>
 */


function tranformerAuteur($pdoConnection, $isbn){

    //****************************************************************
    // G) Requête pour les auteur (nom, biographie, url_blogue)
    //****************************************************************
    $strSQLinfoAuteur = 'SELECT nom_auteur, biographie, url_blogue
                                     FROM (t_auteur INNER JOIN ti_auteur_livre ON t_auteur.id_auteur = ti_auteur_livre.id_auteur) INNER JOIN t_livre ON t_livre.id_livre = ti_auteur_livre.id_livre  
                                     WHERE isbn=:isbn';

    //Exécution de la requête
    $resultatAuteur = $pdoConnection->prepare($strSQLinfoAuteur);
    $resultatAuteur->bindValue('isbn', $isbn, PDO::PARAM_INT);
    $resultatAuteur->execute();


    while ($arrLigneAuteur = $resultatAuteur->fetch()) {
        $arrInfoAuteurs[] = array(
            'nom_auteur' => changerPrenomNom($arrLigneAuteur['nom_auteur']),
            'biographie' => $arrLigneAuteur['biographie'],
            'url_blogue' => $arrLigneAuteur['url_blogue']
        );

    }
    //Libération de la requête
    $resultatAuteur->closeCursor();

    return $arrInfoAuteurs;
}

function changerPrenomNom($strNomPrenom){
    $arrAuteurPrenomNom = explode(", ", $strNomPrenom);

    $arrAuteurPrenomNom = array_reverse($arrAuteurPrenomNom);

    $strPrenonNom = implode(" ", $arrAuteurPrenomNom);

    return $strPrenonNom;


}



?>