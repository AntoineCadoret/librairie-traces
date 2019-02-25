<?php
/*
 * @desc code logique pour le fil d'ariane pour les pages
 * @author Michaël Croteau <mickeycroteau@gmail.com>
 * @version 1.0
 * @date 1-11-18
*/

//Inclure pour aller chercher nom catégorie
require_once($strNiveau . 'inc/scripts/categories.inc.php');
//Inclure classe pour améliorer le titre livre
require_once($strNiveau . 'inc/scripts/ameliorerTitre.php');
//

//Démarrage de la session et la création de la variable session au besoin
session_start();
if (!isset($_SESSION['filAriane'])) {
    $_SESSION['filAriane'] = array();
}


/***************************************************************
 * Requête pour aller chercher le titre du livre (pour afficher dans le fil d'Ariane)
 ****************************************************************/
if (isset($_GET['isbn'])) {
    $isbn = ($_GET['isbn']);
    $_SESSION['filAriane']['isbn_livre'] = $isbn;
}

$strSQLLivre = 'SELECT titre_livre                          
                             FROM t_livre
                             WHERE isbn =:isbn';

//Exécution de la requête
$resultatLivre = $objPdoConnexion->prepare($strSQLLivre);
$resultatLivre->bindValue('isbn', $_SESSION['filAriane']['isbn_livre'], PDO::PARAM_INT);
$resultatLivre->execute();

while ($arrLigneLivre = $resultatLivre->fetch()) {
    $arrLivres = array(
        'titre_livre' => ameliorerTitre($arrLigneLivre['titre_livre'])
    );
}


/***************************************************************
 * Vérifier et validation des différents paramètres
 ****************************************************************/

//*** Vérifications selon les paramètres(peu importe la page)*****
// Vérification du filtre Nouveautés

if (isset($_GET['contexte'])) {
    $_SESSION['filAriane']['nouveaute'] = true;
    $_SESSION['filAriane']['categorie'] = null;
} // Vérification du filtre Catégorie
else if (isset($_GET['categorie'])) {
    $_SESSION['filAriane']['nouveaute'] = null;
    $_SESSION['filAriane']['categorie'] = $_GET['categorie'];
} else if (strpos($_SERVER['PHP_SELF'], 'livres/index.php')) {
    $_SESSION['filAriane']['nouveaute'] = null;
    $_SESSION['filAriane']['categorie'] = null;
}


//  *** Vérification selon le fichier ***************************************

// Vérification de la pagination et du tri dans le fichier --> livres
if (strpos($_SERVER['PHP_SELF'], 'livres/index.php')) {

    // pour le numéro de page ******
    if (isset($_GET['page'])) {
        $_SESSION['filAriane']['page'] = $_GET['page'];
    } else {
        $_SESSION['filAriane']['page'] = null;
    }
    // pour le tri de page ******
    if (isset($_GET['tri'])) {
        $_SESSION['filAriane']['tri'] = $_GET['tri'];
    } else {
        $_SESSION['filAriane']['tri'] = null;
    }
}

// Si j'arrive sur la fiche livre à partir de la section Nouveautés sur l'accueil,
// Supprimer le parametre de page


else if (strpos($_SERVER['PHP_SELF'], 'livres/fiche.php')) {
    if (isset($_GET['contextee'])) {
        $_SESSION['filAriane']['page'] = null;
        $_SESSION['filAriane']['tri'] = null;
    }

}

//var_dump($_SESSION['filAriane']);


/***************************************************************
 * Construction du tableau du fil ariane (selon les parametres enregistrer précédement)
 ****************************************************************/

$arrParamsUrl = array();
$arrFilAriane = array();

// construction fils ariane
array_push($arrFilAriane, array(
    'libelle' => 'Accueil',
    'url' => $strNiveau
));


if (isset($_SESSION['filAriane']['page'])) {
    array_push($arrParamsUrl, 'page=' . $_SESSION['filAriane']['page']);
}

//Ajout du lien avec le tri de la page catégorie

if (isset($_SESSION['filAriane']['tri'])) {
    array_push($arrParamsUrl, 'tri=' . $_SESSION['filAriane']['tri']);
}


//Ajout du lien par rapport au contexte (nouveauté ?)
if ($_SESSION['filAriane']['nouveaute']) {
    array_push($arrParamsUrl, 'contextee=nouveautes');
    array_push($arrFilAriane, array(
        'libelle' => 'Nouveautés',
        'url' => $strNiveau . "livres/index.php?" . implode("&", $arrParamsUrl)
    ));
} else if ($_SESSION['filAriane']['categorie']) {
    // On récupère le nom de la catégorie
    $categorie = getCategorie($objPdoConnexion, $_SESSION['filAriane']['categorie'] );
    array_push($arrParamsUrl, 'categorie=' . $_SESSION['filAriane']['categorie']);
    array_push($arrFilAriane, array(
        'libelle' => $categorie,
        'url' => $strNiveau . 'livres/index.php?' . implode("&", $arrParamsUrl)
    ));
}

// Ajout du lien par rapport à fiche
if (strpos($_SERVER['PHP_SELF'], 'livres/fiche.php')) {
    array_push($arrFilAriane, array(
        // Faire attention que $livre[titre] soit bien défini dans le fichier logique fiche
        // avant l'inclusion du fil ariane
        'libelle' => ameliorerTitre($arrLivres['titre_livre']), // probleme ici   ($arrLivre['titre_livre'])
        'url' => null
    ));
}


// On enlève le lien du dernier élément (page courant) --> fil d'Ariane
$arrFilAriane[count($arrFilAriane) - 1]['url'] = null;

$objTpl->arrFilAriane = $arrFilAriane;

