<?php
$strNiveau = "../";
/**
 * Created by PhpStorm.
 * User: etu01
 * Date: 18-09-19
 * Time: 12:10
 * @TODO 1. aller chercher tout les livres
 * @TODO 2. pagination
 * @TODO 3. aller chercher si il y en a une vignette du livre
 * @TODO 4. aller chercher le titre du livre
 * @TODO 5. aller chercher le nom du ou des auteurs
 * @TODO 6. aller chercher les catégories
 * @TODO 7. chercher contexte
 * @TODO 8. chercher page
 * 9. tri
 * @TODO 10. fil d'ariane
 * @TODO 11. connexion/ déconnexion
 * 12. langue
 */

// Savant 3
require_once($strNiveau . 'inc/lib/Savant3.class.php');
require_once($strNiveau . 'inc/scripts/config.inc.php');
// Instancier, configurer et afficher le template
$arrConfigTpl = array(
    'template_path' => array($strNiveau . 'views', $strNiveau . 'views/partials')
);
$objTpl = new Savant3($arrConfigTpl);

//Inclusion
require_once($strNiveau . 'inc/scripts/transformerAuteur.php');
require_once ($strNiveau . 'inc/scripts/conversion_isbn.php');
require_once($strNiveau . 'inc/scripts/ameliorerTitre.php');
require_once($strNiveau . 'inc/fil-ariane.php');
// Inclure la classe php
require_once($strNiveau . 'inc/Panier.class.php');

// inclusion du script localiser
require_once($strNiveau . 'inc/scripts/localiser.inc.php');


//Ici on récupère la langue dans la "querystring"
$objTpl->langue =  $strLangue;

$strTri="";
if (isset($_SESSION['panier'])) {
    $objPanier = unserialize($_SESSION['panier']);
    $X = "";
    $retroPanier = "";
} else {
    $objPanier = new Panier();
    $X = "";
    $retroPanier = "";
}
if(isset($_GET['contexte']) == true){
    $strContexte=$_GET['contexte'];
}
else{
    $strContexte = 0;
}
if(isset($_GET['page']) == true){
    //Si la page existe dans l'url
    $intNoPage=$_GET['page'];
}else{
    $intNoPage = 0;
}
if(isset($_GET['tri']))
{
    $strTri = $_GET['tri'];
}
else
{
    //echo"dedans";
    $strTri = "AZ";
}
if(isset($_GET['categorie']))
{
    $intCategorie = $_GET['categorie'];
}
else
{
    $intCategorie = 0;
}

$strCategorie = 'SELECT id_categorie, nom_fr, nom_en FROM t_categorie';
$resultatCategorie = $objPdoConnexion->query($strCategorie);
$arrCategorie = array();
if($resultatCategorie->execute()){
    while($arrLigneCategorie = $resultatCategorie->fetch()){
        $arrCategorie[]=array(
            'id_categorie' => $arrLigneCategorie['id_categorie'],
            'nom_fr' => $arrLigneCategorie['nom_fr'],
            'nom_en' => $arrLigneCategorie['nom_en']
        );
    }
    //$intPosCategorie=array_search($intCategorie,$arrCategorie);

    $resultatCategorie->closeCursor();
}
//reecrire nom catégorie pour url
$intPosCategorie = null;
for($intCptCategorie=0; $intCptCategorie<count($arrCategorie);$intCptCategorie++)
{
    if($intCategorie == $arrCategorie[$intCptCategorie]['id_categorie']){
        $intPosCategorie=$intCptCategorie+1;
        //echo $intPosCategorie;

    }


    $strNomCategorie = $arrCategorie[$intCptCategorie]['nom_fr'];
    //echo $strNomCategorie." = ". strpos($strNomCategorie,'é'). ";  ";
   // echo $strNomCategorie." -> ".$strCategorieUrl." ;  ";
//    {
//        $strCategorieUrl = str_replace('é','e', $strNomCategorie);
//       echo $strNomCategorie." -> ".$strCategorieUrl." ;  ";
//    }
//    if(strpos($strNomCategorie,'é')!="")
//    {
//        $strCategorieUrl = str_replace('é','e', $strNomCategorie);
//        echo $strNomCategorie." -> ".$strCategorieUrl." ;  ";
//    }

    //$strCategorieUrl = str_replace('é','e', $strNomCategorie);
}
//calcul du nombre de pages pour pagination

$intNbreItemsParPage = 8;

$intIndexPremierItem = $intNoPage * $intNbreItemsParPage;
if($intCategorie == 0) {
    $strLivre = 'SELECT id_livre, titre_livre, isbn, prix FROM  t_livre';
    $resultatLivre = $objPdoConnexion->query($strLivre);
}
else{
    $strSQLAvecParams = "SELECT t_livre.id_livre, titre_livre, isbn, prix FROM  ti_categorie_livre INNER JOIN t_livre ON t_livre.id_livre = ti_categorie_livre.id_livre  WHERE id_categorie = :categorie";
    $resultatLivre = $objPdoConnexion->prepare($strSQLAvecParams);
    $resultatLivre->bindValue('categorie', $intCategorie,PDO::PARAM_INT);
}

$resultatLivre->execute();

$intNbreTotalItems = $resultatLivre->rowCount();

$resultatLivre->closeCursor();

$intNbreTotalPages = ceil($intNbreTotalItems / $intNbreItemsParPage) - 1;

//requête SQL principal avec tri
if($intCategorie == 0) {
    switch ($strTri) {
        case "AZ":

            if($strContexte != 0){
                echo "dedans";
                $strSQLAvecParams = "SELECT id_livre, titre_livre, isbn, prix FROM  t_livre LIMIT :index, :nombre WHERE id_parution = 3";
            }
            else{
                $strSQLAvecParams = "SELECT id_livre, titre_livre, isbn, prix FROM  t_livre LIMIT :index, :nombre";
            }

            break;
        case "ZA":
            if($strContexte != 0)
            {
                $strSQLAvecParams = "SELECT id_livre, titre_livre, isbn, prix FROM  t_livre WHERE id_parution = 3 ORDER BY titre_livre DESC LIMIT :index, :nombre ";
            }
            else{
                $strSQLAvecParams = "SELECT id_livre, titre_livre, isbn, prix FROM  t_livre ORDER BY titre_livre DESC LIMIT :index, :nombre";
            }
            break;
        case "prixCoissant":
            if($strContexte != 0)
            {
                $strSQLAvecParams = "SELECT id_livre, titre_livre, isbn, prix FROM  t_livre ORDER BY prix LIMIT :index, :nombre WHERE id_parution = 3";
            }
            else{
                $strSQLAvecParams = "SELECT id_livre, titre_livre, isbn, prix FROM  t_livre ORDER BY prix LIMIT :index, :nombre";
            }
            break;
        case "prixDécroissant":
            if($strContexte != 0)
            {
                $strSQLAvecParams = "SELECT id_livre, titre_livre, isbn, prix FROM  t_livre ORDER BY prix DESC LIMIT :index, :nombre WHERE id_parution = 3";
            }
            else{
                $strSQLAvecParams = "SELECT id_livre, titre_livre, isbn, prix FROM  t_livre ORDER BY prix DESC LIMIT :index, :nombre";
            }
            break;
    }
    $resultatPrepareLivre = $objPdoConnexion->prepare($strSQLAvecParams);
    $resultatPrepareLivre->bindValue('index', $intIndexPremierItem, PDO::PARAM_INT);
    $resultatPrepareLivre->bindValue('nombre', $intNbreItemsParPage,PDO::PARAM_INT);
}
else {
    switch ($strTri) {
        case "AZ":
            $strSQLAvecParams = "SELECT t_livre.id_livre, titre_livre, isbn, prix FROM  ti_categorie_livre INNER JOIN t_livre ON t_livre.id_livre = ti_categorie_livre.id_livre  WHERE id_categorie = :categorie LIMIT :index, :nombre";
            break;
        case "ZA":
            $strSQLAvecParams = "SELECT t_livre.id_livre, titre_livre, isbn, prix FROM  ti_categorie_livre INNER JOIN t_livre ON t_livre.id_livre = ti_categorie_livre.id_livre  WHERE id_categorie = :categorie ORDER BY titre_livre DESC LIMIT :index, :nombre";
            break;
        case "prixCoissant":
            $strSQLAvecParams = "SELECT t_livre.id_livre, titre_livre, isbn, prix FROM  ti_categorie_livre INNER JOIN t_livre ON t_livre.id_livre = ti_categorie_livre.id_livre  WHERE id_categorie = :categorie ORDER BY prix LIMIT :index, :nombre";
            break;
        case "prixDécroissant":
            $strSQLAvecParams = "SELECT t_livre.id_livre, titre_livre, isbn, prix FROM  ti_categorie_livre INNER JOIN t_livre ON t_livre.id_livre = ti_categorie_livre.id_livre  WHERE id_categorie = :categorie ORDER BY prix DESC LIMIT :index, :nombre";
            break;
    }
    $resultatPrepareLivre = $objPdoConnexion->prepare($strSQLAvecParams);
    $resultatPrepareLivre->bindValue('index', $intIndexPremierItem, PDO::PARAM_INT);
    $resultatPrepareLivre->bindValue('nombre', $intNbreItemsParPage,PDO::PARAM_INT);
    $resultatPrepareLivre->bindValue('categorie', $intCategorie,PDO::PARAM_INT);
}




$arrLivre=array();
if ($resultatPrepareLivre->execute()) {
    while ($arrLigneLivre = $resultatPrepareLivre->fetch()) //fetch reoutrne un tableau associatif
    {
        $isbn = $arrLigneLivre['isbn'];
//        requête auteurs du livres
        $arrAuteurs[]=array(
                    'info_auteur' => tranformerAuteur($objPdoConnexion, $isbn)
        );
        $arrLivre[] = array(
            'isbn' => $arrLigneLivre['isbn'],
            'id_livre' => $arrLigneLivre['id_livre'],
            'titre_livre' => ameliorerTitre($arrLigneLivre['titre_livre']),
            'prix' => $arrLigneLivre['prix'],
            'auteurMultiple'=>$arrAuteurs
        );
        $arrAuteurs = null;
    }
    //Libération de la requête
    $resultatPrepareLivre->closeCursor();
   // var_dump($arrLivre);
}
$arrConfigTpl = array(
    'template_path' =>array($strNiveau.'views', $strNiveau.'views/partials')
);


$objTpl->niveau = $strNiveau;
$objTpl->nombreArticles = $objPanier->calculerQteLivre();
$objTpl->x = $X;
$objTpl->retroPanier = $retroPanier;
$objTpl->noCategorie = $intCategorie;
$objTpl->noPosCategorie = $intPosCategorie;
$objTpl->categories = $arrCategorie;
$objTpl->tri = $strTri;
$objTpl->livres = $arrLivre;
$objTpl->numeroPage = $intNoPage;
$objTpl->nombreTotalPages = $intNbreTotalPages;
$objTpl->filAriane = $objTpl->fetch('partials/fil-ariane.tpl.php');
$objTpl->entete = $objTpl->fetch('entete.tpl.php');
$objTpl->pieddepage = $objTpl->fetch('pieddepage.tpl.php');
$objTpl->display('livre.tpl.php');
