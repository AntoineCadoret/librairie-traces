<?php
/**
 * @desc Logique de la page d'accueil de la librairie Traces
 * @author Beverly Cagelet <beverly.cagelet.protic@gmail.com>
 * @version 1.0
 * @date 26-09-18
 * 1. Aller chercher la langue
 * TODO 2. Vérifier si c'est un client connecté ou pas {nav}
 * 3. Aller chercher les nouveautés (titre, vignette, auteur, prix,) {section nouveautés}
 * 4. Envoyer le contexte de nouveautés vers le catalogue {section nouveautés}
 * 5. Aller chercher les actualités ([1]titre + [2]auteur + [3]date (de manière antéchronologique) + [4]image + [5]nouvelle, liens) {zone actualités}
 * 6. Aller chercher les livres (nom, auteur, prix)
 * 7. Aller chercher les coups de coeur (Titre, prix, ajouter au panier, etc)
 * 8. Envoyer l'ISBN vers la page fiche
 *
 * TODO - récits restants (A)
 * Après confirmation d’une commande, les infos de la transaction courante
doivent avoir été effacées. Le panier doit être vide. Seules les infos du client authentifié
doivent être encore actives : [arrAuthentification]
 *
 * Zone «Actualités littéraires»
 * Le lien pour lire la suite de l’actualité doit être construit dynamiquement mais la page cible n’est pas à faire.

Autres spécifications techniques / Mandat A
● S’il y a des liens redondants comme . Lire la suite ., leur cible (le titre de l’article) est pr.cis.e dans un span visuallyhidden ou
dans le alt d’une <img> →
● Tous les éléments d’interfaces ainsi que les images doivent être traduits selon le choix de langue fait par l'usager. De plus, les
contenus en provenance de la base de données pouvant être affichés selon la langue doivent l’être.
Chacun est responsable de la localisation de sa page de catalogue : identifier les chaînes à traduire.
Le mandat A doit préparer des fichiers images alternatifs en anglais, si les images contiennent des mots en français.
● L’auto complétion de la zone de recherche est programmée par le mandat B et doit être fonctionnelle dans chacune des pages
incluant la zone de recherche. Le formulaire de zone de recherche n’est pas soumis, seule l’auto complétion est programmé.
● Lorsqu'un usager est connecté, le lien "se connecter" bascule vers un lien "se déconnecter".
Le clic sur le lien déconnexion doit permettre la déconnexion réelle et le retour au lien "se connecter" après rappel de la page
courante.

 */

$strNiveau = "./";
//$strLangue = "fr";


// Savant 3
require_once($strNiveau . 'inc/lib/Savant3.class.php');
require_once($strNiveau . 'inc/scripts/config.inc.php');
// Instancier, configurer et afficher le template
$arrConfigTpl = array(
    'template_path' => array($strNiveau . 'views', $strNiveau . 'views/partials')
);
$objTpl = new Savant3($arrConfigTpl);
$objTpl->erreur = false;


//Inclusions
// inclusion du script localiser
require_once($strNiveau . 'inc/scripts/localiser.inc.php');
require_once($strNiveau . 'inc/scripts/transformerAuteur.php');
require_once($strNiveau . 'inc/scripts/ameliorerTitre.php');
require_once ($strNiveau . 'inc/scripts/conversion_isbn.php');
require_once($strNiveau . 'inc/Panier.class.php');


session_start();

//Ici on récupère la langue dans la "querystring"
$objTpl->langue =  $strLangue ;

if (isset($_SESSION['panier'])) {
    $objPanier = unserialize($_SESSION['panier']);
    $X = "";
    $retroPanier = "";
} else {
    $objPanier = new Panier();
    $X = "";
    $retroPanier = "";
}



////////////////1-REQUÊTE POUR LES COUPS DE COEUR\\\\\\\\\\\\\\\\\
//Requête
$strCoupCoeur = 'SELECT t_livre.id_livre, titre_livre, prix, description_livre
                 FROM t_livre
                 WHERE est_coup_de_coeur = 1
                 LIMIT 0,1';

//Exécution de la requête
$resultatsCoupCoeur = $objPdoConnexion->query($strCoupCoeur);

//Tableau pour avoir les infos
$arrCoupsCoeur = array();
if ($resultatsCoupCoeur->execute()) {
    while ($arrLigneCoeur = $resultatsCoupCoeur->fetch()) {
        $arrCoupsCoeur[] = array(
            'id_livre' => $arrLigneCoeur['id_livre'],
            'titre_livre' => $arrLigneCoeur['titre_livre'],
            'prix' => $arrLigneCoeur['prix'],
            'description_livre' => raccourcirTexte($arrLigneCoeur['description_livre']),
        );
    }
}


///////////////2-REQUÊTE POUR LES NOUVEAUTÉS\\\\\\\\\\\\\\\\\
//~Requête
$strNouveautes = 'SELECT DISTINCT titre_livre, prix, isbn
                  FROM t_livre
                  INNER JOIN t_parution ON t_livre.id_parution = t_parution.id_parution
                  WHERE t_parution.id_parution = 3';

//~~Préparation de la requete
$resultatNouveautes = $objPdoConnexion->prepare($strNouveautes);


//~~~Tableau pour avoir les infos
$arrNouveautes = array();
$arrNouveautesChoisies = array();
$arrAuteurs = array();
$isbn = "";
$intNbNouveautes = 5;

if ($resultatNouveautes->execute()) {
    while ($arrLigneNouveautes = $resultatNouveautes->fetch()) {

        $isbn = $arrLigneNouveautes['isbn'];

        $arrAuteurs[] = array(
            'nom_auteur' => tranformerAuteur($objPdoConnexion, $isbn)
        );
        $arrNouveautes[] = array(
            'titre_livre' => ameliorerTitre($arrLigneNouveautes['titre_livre']),
            'prix' => $arrLigneNouveautes['prix'],
            'isbn' => $arrLigneNouveautes['isbn'],
            'nomFicher' => ISBNToEAN($arrLigneNouveautes['isbn']),
            'auteurMultiple' => $arrAuteurs,
        );

        $arrAuteurs = null;
        ///// FIN DE LA REQUÊTE SPÉCIALE
    }
}
//Libération de la requete
$resultatNouveautes->closeCursor();

////Tirage au sort
/**
 * 1- Tirer un nombre
 * 2- Mettre dans les nouveautés choisies
 * 3- Enlever la nouveauté choisie des suggestions disponibles (évite les doublons)
 **/

for ($intCpt=0; $intCpt<$intNbNouveautes; $intCpt++){
    $intIndexHazard = rand(0, (count($arrNouveautes))-1);
    array_push($arrNouveautesChoisies, $arrNouveautes[$intIndexHazard]);
    array_splice($arrNouveautes, $intIndexHazard, 1);
}


////////////////3-REQUÊTE POUR LES ACTUALITÉS\\\\\\\\\\\\\\\\\
//~Requête
$strActualites = 'SELECT t_actualite.id_actualite, titre_actualite, texte_actualite, date_actualite, t_auteur.nom_auteur
                  FROM t_actualite
                  INNER JOIN t_auteur ON t_actualite.id_auteur = t_auteur.id_auteur
                  ORDER BY date_actualite DESC
                  LIMIT 0,3';

//~~~Exécution de la requête
$resultatsActualites = $objPdoConnexion->query($strActualites);

//Tableau pour avoir les infos
$arrActualites = array();
if ($resultatsActualites->execute()) {
    while ($arrLigneActualites = $resultatsActualites->fetch()) {

        $arrActualites[] = array(
            'id_actualite' => $arrLigneActualites['id_actualite'],
            'titre_actualite' => $arrLigneActualites['titre_actualite'],
            'texte_actualite' => raccourcirTexte($arrLigneActualites['texte_actualite']),
            'nom_auteur' => changerNomAuteur($arrLigneActualites['nom_auteur']),
            'date_actualite' => modifierDate($arrLigneActualites['date_actualite']),
        );
    }
    //Libération de la requete
    $resultatsActualites->closeCursor();
}


//Méthodes utilitaires
/**
 * Transforme le nom "Cagelet, Beverly" en "Beverly Cagelet"
 *  $strNomPrenom - {string}
 **/
function changerNomAuteur($strNomPrenom)
{
    $arrAuteurPrenomNom = explode(", ", $strNomPrenom);
    $arrAuteurPrenomNom = array_reverse($arrAuteurPrenomNom);
    $strPrenonNom = implode(" ", $arrAuteurPrenomNom);
    return $strPrenonNom;
}

/**
 * Raccourci le texte en ajoutant ... après
 *  $strDescription - {string}
 **/
function raccourcirTexte($strDescription)
{
    $longueurMaximum = 320;

    if (strlen($strDescription) > $longueurMaximum)
    {
//        $strDescription = substr($strDescription, 0, 340);
//        $strDescription = substr($strDescription, 0, strrpos($strDescription, ' ')) . " ...";
        $coupure = ($longueurMaximum - 3) - strlen($strDescription);
        $strDescription = substr($strDescription, 0, strrpos($strDescription, ' ', $coupure)) . '...';
    }
    return $strDescription;
}

/**
 * Affiche une date proprement
 *  $date - {string}
 **/
function modifierDate($date)
{
    $arrMois = array(
        "Jan", "Fév", "Mar", "Avr", "Mai", "Juin", "Juil", "Août", "Sep", "Oct", "Nov", "Déc"
    );

    $annee = substr($date, 0, 4);
    $mois = substr($date, 5, 2);
    $jour = substr($date, 8, 2);

    $nouvelleDate = $jour . " " . $arrMois[$mois - 1] . " " . $annee . " ";
    return $nouvelleDate;
}

$arrConfigTpl = array(
    'template_path' => array($strNiveau . 'views', $strNiveau . 'views/partials')
);


$objTpl->nombreArticles = $objPanier->calculerQteLivre();
$objTpl->x = $X;
$objTpl->retroPanier = $retroPanier;
$objTpl->coupCoeur = $arrCoupsCoeur;
$objTpl->nouveautes = $arrNouveautesChoisies;
$objTpl->actualites = $arrActualites;
//$objTpl->nomFichier = $nomFichier;
$objTpl->niveau = $strNiveau;
//$objTpl->nombreArticles = $objPanier->calculerQteLivre();
$objTpl->entete = $objTpl->fetch('entete.tpl.php');
$objTpl->pieddepage = $objTpl->fetch('pieddepage.tpl.php');
//Pour la rétroaction du panier
$objTpl->display('index.tpl.php');

