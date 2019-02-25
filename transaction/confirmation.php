<?php
$strNiveau = '../';
require_once($strNiveau . 'inc/Panier.class.php');
require_once($strNiveau . 'inc/scripts/config.inc.php');
require_once($strNiveau . 'inc/lib/Savant3.class.php');
require_once($strNiveau . 'inc/scripts/routeur.class.php');
require_once($strNiveau . 'inc/scripts/localiser.inc.php');
$router = new Routeur();
$arrConfigTpl = array(
    'template_path' => array($strNiveau . 'views', $strNiveau . 'views/partials')
);

session_start();
//if (isset($_SESSION['arrAuthentification'])!= "") {

//Si le panier existe (je le récupère)
    if (isset($_SESSION['panier'])) {
        $objPanier = unserialize($_SESSION['panier']);
    } else {
        $objPanier = new Panier();
    }
    if (isset($_SESSION['arrTransaction'])) {
        $arrTransaction = unserialize($_SESSION['arrTransaction']);
    } else {
        echo "dedans";
    }
    if (isset($_GET['destroy'])) {
        $router->detruireSession();
        header('location:' . $strNiveau . 'index.php');
    }
//Tableau pour les dates (date de livraison)
    $arrMois = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");

//Les variables
    $intIsbnARetirer = 0;
    $strTypeLivraison = "standard";
    $dateLivraison = "";
    $dateAujourdhui = new DateTime("now", new DateTimeZone("America/Montreal"));

    if (isset($_COOKIE['langue'])) {
        $strLangue = $_COOKIE['langue'];
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

// Retirer tous les livres ********************************
    if (isset($_GET['viderPanier'])) {
        $objPanier->supprimerToutPanier();
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

    $objTpl = new Savant3($arrConfigTpl);

//    session_destroy();


//envoyer courriel
//header('location:'.$strNiveau.'courriel.php');

// Instancier, configurer et afficher le template
    $objTpl->erreur = false;
    $objTpl->niveau = $strNiveau;
    $objTpl->objPanier = $objPanier;
    $objTpl->tableauPanier = $objPanier->retournerPanier();
    $objTpl->sousTotal = $intSousTotal;
    $objTpl->nombreTotalArticle = $intNbrTotalItems;
    $objTpl->TPS = $intTPS;
    $objTpl->fraisLivraison = $intFraisLivraison;
    $objTpl->coutTotal = $intCoutTotal;
    $objTpl->typeLivraison = $strTypeLivraison;
    $objTpl->dateLivraison = $dateLivraison;
    $objTpl->arrTransaction = $arrTransaction;
    $objTpl->entete = $objTpl->fetch('entete-transaction.tpl.php');
    $objTpl->pieddepage = $objTpl->fetch('pieddepage-transaction.tpl.php');
//    if (isset($_SESSION['arrTransaction'])) {
        $objTpl->display('confirmation.tpl.php');
//    } else {
//        header('location:' . $strNiveau . 'index.php');
//    }
//}
//else {
//    header('location:'.$strNiveau.'connexion.php');
//}