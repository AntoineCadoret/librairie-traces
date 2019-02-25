<?php
/**
 * @desc L'aller chercher les nom des catégories
 * @author Michaël Croteau <mickeycroteau@gmail.com>
 * version 1.0
 * Date: 18-11-01
 */


function getCategorie($pdoConnection, $intCategorie)
{

    //****************************************************************
    // Requête pour aller chercher nom categorie
    //****************************************************************
    $strSQLinfoAuteur = 'SELECT nom_fr, nom_en                           
                         FROM t_categorie
                         WHERE id_categorie =:id_categorie';

    //Exécution de la requête
    $resultatCategorie = $pdoConnection->prepare($strSQLinfoAuteur);
    $resultatCategorie->bindValue('id_categorie', $intCategorie, PDO::PARAM_INT);
    $resultatCategorie->execute();


    while ($arrLigneCategorie = $resultatCategorie->fetch()) {
        $arrInfoCategorie = array(
            'id' => $intCategorie,
            'nom_fr' => $arrLigneCategorie['nom_fr'],
            'nom_en' => $arrLigneCategorie['nom_en']
        );

    }
    //Libération de la requête
    $resultatCategorie->closeCursor();


    //Vérifier le cookie de la langue
    if(isset($_COOKIE['langue']) && $_COOKIE['langue'] == 'fr') {
        return $arrInfoCategorie['nom_fr'];
    }
    else if (isset($_COOKIE['langue']) && $_COOKIE['langue'] == 'en') {
        return $arrInfoCategorie['nom_en'];
    }
    else{
        return $arrInfoCategorie['nom_fr'];
    }


    /*
    if (isset($languee) && $langue = 'fr') {
        return $arrInfoCategorie['nom_fr'];
    } else if (isset($langue) && $langue = 'en') {
        return $arrInfoCategorie['nom_en'];
    } else {
        return $arrInfoCategorie['nom_fr'];
    }
    */

}


?>