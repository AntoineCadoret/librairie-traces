<?php
/**
 * Created by PhpStorm.
 * User: etu01
 * Date: 18-10-23
 * Time: 11:22
 */

$strNiveau = './';
require_once($strNiveau . 'inc/Panier.class.php');
require_once($strNiveau . 'inc/scripts/config.inc.php');
require_once($strNiveau . 'inc/lib/Savant3.class.php');
require_once($strNiveau . 'inc/scripts/routeur.class.php');
$routeur = new routeur();
$arrConfigTpl = array(
    'template_path' => array($strNiveau . 'views', $strNiveau . 'views/partials')
);
session_start();



if (isset($_SESSION['panier'])) {
    $objPanier = unserialize($_SESSION['panier']);
    $X = "";
    $retroPanier = "";
} else {
    $X = "";
    $retroPanier = "";
    $objPanier = new Panier();
}

$prenomClient = "";
$nomClient = "";
$motDePasseClient = "";
$courrielClient = "";

if(isset($_GET['inscription']))
{
    $inscription = $_GET['inscription'];
    //Inscription
    if($inscription == 'true')
    {
        if (isset($_GET['prenom'])) {
            if (isset($_GET['nom'])) {
                if(isset($_GET['telephone'])) {
                    if (isset($_GET['courriel'])) {
                        if (isset($_GET['motPasse'])) {
                            //$arrNouveauMembre=array('client','livraison','facturation','mode_paiement');
                            //var_dump($arrNouveauMembre);
                            $arrNouveauMembre['client'] = array(
                                'prenom' => $_GET['prenom'],
                                'nom' => $_GET['nom'],
                                'telephone' => $_GET['telephone'],
                                'courriel' => $_GET['courriel'],
                                'motPasse' => $_GET['motPasse'],
                            );
                            $arrNouveauMembre['livraison'] = array(
                            );
                            $_SESSION['arrNouveauMembre'] = serialize($arrNouveauMembre);
                            $_SESSION['authentification'] = "inscription";
                            header('location:' . $strNiveau . 'transaction/livraison.php');
                        }
                    }
                }
            }
        }
    }
    else
    {
        //Connexion
        if (isset($_GET['courriel']))
        {
            if (isset($_GET['motPasse']))
            {
                if($routeur->chercherMotPasse($_GET['courriel'], $objPdoConnexion) == $_GET['motPasse']){
                    $arrTransaction = $routeur->chercherInfo($_GET['courriel'], $objPdoConnexion);
                    $_SESSION['arrTransaction'] = serialize($arrTransaction);

//                    $Session_ID = session_id();
                    $_SESSION['authentification'] = "connecte";

                    header('location:'.$strNiveau.'transaction/validation.php');
                }
                else{
                    header('location:'.$strNiveau.'connexion.php');
                }

            }
        }
    }
}

$objTpl = new Savant3($arrConfigTpl);
$objTpl->nombreArticles = $objPanier->calculerQteLivre();
$objTpl->x = $X;
$objTpl->retroPanier = $retroPanier;
$objTpl->niveau = $strNiveau;
$objTpl->entete = $objTpl->fetch('entete-transaction.tpl.php');
$objTpl->pieddepage = $objTpl->fetch('pieddepage-transaction.tpl.php');
$objTpl->display('connexion.tpl.php');