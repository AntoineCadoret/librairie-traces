<?php
/**
 * @auteur Michaël Croteau <mickeycroteau@gmail.com>
 * @todo une requete à la base de données bd_provinces
 * pour trouver la province correspondante à la première lettre du code postal.
 *
 * RETOURNER 0 ou les 2 lettres d'abbréviation de la Province
 */

/* lettre=k (qu'est ce qui est retourner) */
// organiser que le scripte php -->returne la province

//sleep(3);

// Inclusions du fichier de configuration
require_once('../config.inc.php');

if ((isset($_GET['codePostal']) == true) && ($_GET['codePostal'] !== '')) {

    //Garder que la premiere lettre

    $codePostal = $_GET['codePostal'];
    $strPremiereLettre =substr($codePostal,0,1);

    $strRequeteProvince = 'SELECT nom_province, abbr_province 
                               FROM t_province
                               WHERE lettres_code_postal LIKE :lettre';

    $resultatProvince = $objPdoConnexion->prepare($strRequeteProvince);
    $resultatProvince->bindValue('lettre', "%".$strPremiereLettre."%");
    $resultatProvince->execute();
    $intNbreTotalItems = $resultatProvince->rowCount();
    $arrProvince = $resultatProvince->fetch();

    if ($intNbreTotalItems > 0){
        $reponseProvince = $arrProvince['nom_province'];
        $abbrProvince = $arrProvince['abbr_province'];
    }
    else{
        // Retourne 0
        $reponseProvince = $intNbreTotalItems;
        $abbrProvince =  $intNbreTotalItems;
    }

    $resultatProvince->closeCursor();
}
else{
    $reponseProvince = 0;
    $abbrProvince = 0;
}

 //echo('{"nomProvince":' .'"'. $reponseProvince . '", "abbrProvince":"' .$abbrProvince  . '"}');
echo $reponseProvince;

?>

