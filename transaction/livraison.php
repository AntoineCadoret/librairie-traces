<?php
session_start();
if (isset($_SESSION['authentification'])) {
    $authentification = $_SESSION['authentification'];
} else {
    $authentification = "anonyme";
}
if ($authentification == "anonyme") {
    header('location:' . $strNiveau . '../connexion.php');
}

//Définition de la variable de niveau
$strNiveau = "../";

// Savant 3
require_once($strNiveau . 'inc/lib/Savant3.class.php');
require_once($strNiveau . 'inc/scripts/config.inc.php');
require_once($strNiveau . 'inc/scripts/routeur.class.php');

$routeur = new routeur();
if (isset($_SESSION['arrNouveauMembre'])) {
    $arrNouveauMembre = $_SESSION['arrNouveauMembre'];
}
if (isset($_GET['prenom'])) {

    if (isset($_GET['nom'])) {

        if (isset($_GET['adresse'])) {

            if (isset($_GET['ville'])) {

                if (isset($_GET['province'])) {
                    if (isset($_GET['codePostal'])) {


                        if (isset($_GET['adresseParDefaut'])) {
                            $province = $_GET['province'];
                            //echo $province;
                            $abbrProvince = $routeur->trouverAbbrProvince($province, $objPdoConnexion);
                            $arrNouveauMembre['livraison'] = array(
                                'prenom_livraison' => $_GET['prenom'],
                                'nom_livraison' => $_GET['nom'],
                                'adresse_livraison' => $_GET['adresse'],
                                'ville_livraison' => $_GET['ville'],
                                'province_livraison' => $abbrProvince,
                                'codePostal_livraison' => $_GET['codePostal'],
                                'parDefault_livraison' => $_GET['adresseParDefaut']
                            );
                            var_dump($arrNouveauMembre);
                            $_SESSION['arrNouveauMembre'] = serialize($arrNouveauMembre);
                            header('location:' . $strNiveau . 'transaction/facturation.php');

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
if (isset($_SESSION['langue'])) {
    $strLangue = $_SESSION['langue'];
}


// Instancier, configurer et afficher le template
$objTpl->niveau = $strNiveau;
$objTpl->entete = $objTpl->fetch('entete-transaction.tpl.php');
$objTpl->pieddepage = $objTpl->fetch('pieddepage-transaction.tpl.php');
$objTpl->display('livraison.tpl.php');
