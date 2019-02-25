<?php
/*
 * @desc Page panier
 * @author Michaël Croteau <mickeycroteau@gmail.com>
 * @version 1.0
 * @date 17-10-18
*/

//Définition de la variable de niveau
$strNiveau = "../";
require_once($strNiveau . 'inc/lib/Savant3.class.php');
require_once($strNiveau . 'inc/scripts/config.inc.php');

// Instancier, configurer et afficher le template
$arrConfigTpl = array(
    'template_path' => array($strNiveau . 'views', $strNiveau . 'views/partials')
);

$objTpl = new Savant3($arrConfigTpl);
$objTpl->erreur = false;

// inclusion du script localiser
require_once($strNiveau . 'inc/scripts/localiser.inc.php');
// Inclusion du scripte pour conversion isbn pour l'image
require_once($strNiveau . 'inc/scripts/conversion_isbn.php');
// Inclure la classe php
require_once($strNiveau . 'inc/Panier.class.php');
session_start();
//Si le panier existe (je le récupère)
if (isset($_SESSION['panier'])) {
    $objPanier = unserialize($_SESSION['panier']);
} else {
    $objPanier = new Panier();
}

//Tableau pour les dates (date de livraison)
$arrMois = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");

//Les variables
$intIsbnARetirer = 0;
$strTypeLivraison = "standard";
$dateLivraison = "";
$dateAujourdhui = new DateTime("now", new DateTimeZone("America/Montreal"));


//Ici on récupère la langue dans la "querystring"
$objTpl->langue = $strLangue;


if (isset($_SESSION['panier'])) {
    $objPanier = unserialize($_SESSION['panier']);
    $X = "";
    $retroPanier = "";
} else {
    $X = "";
    $retroPanier = "";
}

// Bouton recalculer ********************************
if (isset($_GET['btnRecalculer'])) {

    foreach ($_GET as $isbn => $valeur) {
        if ($valeur != $_GET['btnRecalculer'] && $valeur != $_GET['typeLivraison']) {

            // Si la valeur est 0 = retirer l'item
            if ($valeur == 0) {
                $objPanier->supprimerLivre($isbn);
            } // Sinon modifier la quantité
            else {
                $objPanier->majPanier($isbn, $valeur);
            }
        }
    }
    //maj $objPanier
    $_SESSION['panier'] = serialize($objPanier);
}


// Retirer un livre ********************************
if (isset($_GET["btnRetirer"])) {
    $intIsbnARetirer = $_GET["btnRetirer"];
    //supprimer de classe panier
    $objPanier->supprimerLivre($intIsbnARetirer);
    //maj $objPanier
    $_SESSION['panier'] = serialize($objPanier);
}


// Code pour la Livraison ********************************
if (isset($_GET['typeLivraison'])) {
    $strTypeLivraison = $_GET['typeLivraison'];
}
// estimer la date livraison (ajout)
$dateLivraison = $objPanier->estimerDateLivraison($strTypeLivraison, $dateAujourdhui, $arrMois);


// Calculer les prix *************************************
$intNbrTotalItems = $objPanier->calculerQteLivre();
$intSousTotal = $objPanier->calculerSousTotal();
$intTPS = $objPanier->calculerTPSDesLivres($intSousTotal);
$intFraisLivraison = $objPanier->calculerFraisLivraison($intNbrTotalItems, $strTypeLivraison);
$intCoutTotal = $objPanier->calculerCoutTotal($intSousTotal, $intTPS, $intFraisLivraison);


// Instancier, configurer et afficher le template
$objTpl->objPanier = $objPanier;
$objTpl->niveau = $strNiveau;
$objTpl->tableauPanier = $objPanier->retournerPanier();
$objTpl->sousTotal = $intSousTotal;
$objTpl->nombreTotalArticle = $intNbrTotalItems;
$objTpl->TPS = $intTPS;
$objTpl->fraisLivraison = $intFraisLivraison;
$objTpl->coutTotal = $intCoutTotal;
$objTpl->typeLivraison = $strTypeLivraison;
$objTpl->dateLivraison = $dateLivraison;
//retroaction panier
$objTpl->nombreArticles = $objPanier->calculerQteLivre();
$objTpl->x = $X;
$objTpl->retroPanier = $retroPanier;

$objTpl->display('panier.tpl.php');
?>