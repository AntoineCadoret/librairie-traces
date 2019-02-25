<?php

//Définition de la variable de niveau
$strNiveau = "../";

// Savant 3
require_once($strNiveau . 'inc/lib/Savant3.class.php');
require_once($strNiveau . 'inc/scripts/config.inc.php');
require_once($strNiveau . 'inc/scripts/routeur.class.php');
$routeur = new routeur();
session_start();

if (isset($_SESSION['authentification'])) {
    $authentification=$_SESSION['authentification'];
}
else {
    $authentification= "anonyme";
}
if($authentification=="anonyme")
{
    header('location:' . $strNiveau . 'connexion.php');
}
    if (isset($_SESSION['arrNouveauMembre'])) {
        $arrNouveauMembre = $_SESSION['arrNouveauMembre'];
    }
    if (isset($_GET['modePaiement'])) {
        if (isset($_GET['numCarte'])) {
            if (isset($_GET['nomTitulaire'])) {
                if (isset($_GET['dateExpiration'])) {
                    if (isset($_GET['numSecurite'])) {
                        if (isset($_GET['prenom'])) {
                            if (isset($_GET['nom'])) {
                                if (isset($_GET['adresse'])) {
                                    if (isset($_GET['ville'])) {
                                        if (isset($_GET['province'])) {

                                            if (isset($_GET['codePostal'])) {
                                                $province = $_GET['province'];
                                                //echo $province;
                                                $abbrProvince = $routeur->trouverAbbrProvince($province, $objPdoConnexion);
                                                $arrNouveauMembre['mode_paiement'] = array(
                                                    'est_paypal' => 0,
                                                    'type_carte' => $_GET['modePaiement'],
                                                    'no_carte' => $_GET['numCarte'],
                                                    'nomComplet' => $_GET['nomTitulaire'],
                                                    'date_expiration' => $_GET['dateExpiration'],
                                                    'code' => $_GET['numSecurite']
                                                );
                                                $arrNouveauMembre['facturation']=array(
                                                    'prenom_facturation' => $_GET['prenom'],
                                                    'nom_facturation' => $_GET['nom'],
                                                    'adresse_facturation' => $_GET['adresse'],
                                                    'ville_facturation' => $_GET['ville'],
                                                    'province_facturation' => $province,
                                                    'codePostal_facturation' => $_GET['codePostal']
                                                );
                                                $routeur->ajouterMembre($arrNouveauMembre, $objPdoConnexion);
                                                $arrTransaction = $routeur->chercherInfo($arrNouveauMembre['courriel'], $objPdoConnexion);
                                                $_SESSION['arrTransaction'] = serialize($arrTransaction);
                                                header('location:'.$strNiveau.'transaction/validation.php');
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
// Instancier, configurer et afficher le template
    $arrConfigTpl = array(
        'template_path' => array($strNiveau . 'views', $strNiveau . 'views/partials')
    );
    $objTpl = new Savant3($arrConfigTpl);
    $objTpl->erreur = false;

// inclusion du script localiser
    require_once($strNiveau . 'inc/scripts/localiser.inc.php');

//Ici on récupère la langue dans la "querystring"
    if (isset($_COOKIE['langue'])) {
        $strLangue = $_COOKIE['langue'];
    }


// Instancier, configurer et afficher le template
    $objTpl->niveau = $strNiveau;
    $objTpl->entete = $objTpl->fetch('entete-transaction.tpl.php');
    $objTpl->pieddepage = $objTpl->fetch('pieddepage-transaction.tpl.php');
    $objTpl->display('facturation.tpl.php');
