<?php
/**
 * Script appeler par JavaScript pour mettre à jour le panier et afficher la rétroaction d'ajout au panier
 * @todo on reçoit un isbn (et un prix?)
 * @todo on doit maj le panier
 * @todo incrémenter et stocker le nombre d'items total
 * @todo calculer et stocker le sous-total de tous les articles
 *
 * @return un objet JSON avec le nombre d'articles au panier, le isbn du produit mis au panier et un sous-total
 */

// Dormance de 2 secondes pour tester le spinner
//sleep(2);

require_once('../config.inc.php');
require_once('../../Panier.class.php');

$sousTotal = 38.99;
$isbn = $_GET['isbn'];
$quantiteLivre = $_GET['quantite'];
//$quantiteLivre = 5;
$imageLivre = $_GET['imageLivre'];
$titreLivre = $_GET['titreLivre'];

session_start();

if (isset($_SESSION['panier'])) {
    $objPanier = unserialize($_SESSION['panier']);


    $objPanier->ajouterLivre($objPdoConnexion, $isbn, $quantiteLivre);

    $sousTotal = $objPanier->calculerSousTotal();
//    $sousTotal = 10;
    $quantite = $objPanier->calculerQteLivre();

    //maj $objPanier
    $_SESSION['panier'] = serialize($objPanier);
} else {
    $objPanier = new Panier();

    $objPanier->ajouterLivre($objPdoConnexion, $isbn, $quantiteLivre);

    $sousTotal = $objPanier->calculerSousTotal();
    $quantite = $objPanier->calculerQteLivre();

    //maj $objPanier
    $_SESSION['panier'] = serialize($objPanier);
}






//on commence par une version "codé en dur" qui renvoie tjs la même chose
echo('{"nombreArticles":' . $quantite . ', "isbn":"' . $isbn . '", "titre":"' . $titreLivre . '", "sousTotal":"' . $sousTotal . '", "nombreArticlesAjouter":' . $quantiteLivre . ', "imageLivre":"' . $imageLivre . '"}');
?>

