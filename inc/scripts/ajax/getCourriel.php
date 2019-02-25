<?php
/**
 * une requete à la base de données bd_client
 * pour trouver l'adresse correspondante
 *
 * RETOURNER 0 ou les 2 lettres d'abbréviation de la Province
 */

//sleep(1);
require_once('../config.inc.php');

if((isset($_GET['courriel_client'])==true && $_GET['courriel_client'])!=''){
    $courrielEnvoye = $_GET['courriel_client'];

    $strRequeteCourriel = 'SELECT courriel_client FROM t_client WHERE courriel_client = :courriel_client';

    $resultatCourriel = $objPdoConnexion->prepare($strRequeteCourriel);
    $resultatCourriel->bindValue('courriel_client', $courrielEnvoye);
    $resultatCourriel->execute();
    $intNbreTotalItems = $resultatCourriel->rowCount();
    $unCourriel = $resultatCourriel->fetch();

    if ($intNbreTotalItems != 0){
        $courriel = 1;
    }
    else{
        $courriel = $intNbreTotalItems;
    }
    $resultatCourriel->closeCursor();
}
else {
    $courriel = -1;
}

echo $courriel;