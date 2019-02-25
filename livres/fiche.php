<?php
/*
 * @desc Page Fiche d'un livre
 * @author Michaël Croteau <mickeycroteau@gmail.com>
 * @version 1.0
 * @date 26-09-18
 * DO Requête : (Adapter selon le livre de la page précédente)
 * Do 1. Fils D'ariane (dynamique) ... selon de où il vient
 * Do 2. Vignette du livre ( Dans t_livre: Titre, Sous-titre, Auteur(s), Blog (si disponible), prix livre
 * Todo 2.1 Image du livre (si n'a pas d'image = image général)
 * Do 2.2 Format auteur : Prénom nom (enlever la virgule entre) et si + 1 auteur, ajouter virgule entre
 * Do 3. Description livre (requête pour t_livre description)
 * Do 4. infos publication:t_livres -> nbr page, caractéristique, ISBN, année d'édition, maison édition, (si site web dispo = mettre lien), collection
 * Do 5. Info complémentaire -> t_honneur ( nom_honneur, descripton_honneur )
 * Do 6. "Parler de ce livre:" Court extrait(dans revues et journaux), Date, titre, nom journalisme, nom du média
 * TODO Panier:
 * Todo 1. bouton mise en ligne panier (fait parti d'un form)
 * Todo 2. Nombre articles (lors d'ajout au panier)
 * Todo 3. Sous total de tous les articles
 * Todo 4. Lien "Panier", naviguer -->  Page panier
 * Todo 5. Bouton "passer commande", naviguer --> Page Connexion/Création compte
 * TODO Autre:
 * Todo 1. Zone commentaire (pas programmer... juste intégré)
 * TODO important de lire autre spécification dans scénario
*/

//Définition de la variable de niveau
$strNiveau = "../";


// Savant 3
require_once($strNiveau . 'inc/lib/Savant3.class.php');
require_once($strNiveau . 'inc/scripts/config.inc.php');
// Instancier, configurer et afficher le template
$arrConfigTpl = array(
    'template_path' => array($strNiveau . 'views', $strNiveau . 'views/partials')
);
$objTpl = new Savant3($arrConfigTpl);
$objTpl->erreur = false;

//Inclusion du fil ariane
require_once($strNiveau . 'inc/fil-ariane.php');
//Inclusion transformer nom auteur
require_once($strNiveau . 'inc/scripts/transformerAuteur.php');
//Inclure classe pour améliorer le titre livre
require_once($strNiveau . 'inc/scripts/ameliorerTitre.php');
// inclusion du script localiser
require_once($strNiveau . 'inc/scripts/localiser.inc.php');
// Inclusion du scripte pour conversion isbn pour l'image
require_once($strNiveau . 'inc/scripts/conversion_isbn.php');
// Inclure la classe php
require_once($strNiveau . 'inc/Panier.class.php');


// Variable session
//session_start(); --> session start dans le fil ariane
//Si le panier existe (je le récupère)
if (isset($_SESSION['panier'])) {
    $objPanier = unserialize($_SESSION['panier']);
} else {
    $objPanier = new Panier();
}


//Tableau pour les dates
$arrMois = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");

//Tous les variables
//Initialiser des tableaux (qui accumulera les données de la requête) avant de commencer
$arrLivres = array();
$arrAuteurs = array();
$arrCategories = array();
$arrEditeurs = array();
// Les variables pour les avis
$jsonAvis = file_get_contents($strNiveau . "assets/js/objAvis.json");
$decode_json = json_decode($jsonAvis, true);
//var_dump($decode_json);
$intNbrAvis = 0;
$arrDateHasard = array();
$intIndexHazard = 0;
$arrAvisDisponible = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$arrAvisChoisi = array();
$arrTousInfoAvis = array();
// autre variable
//$strLangue = "fr";
$qteTotalAticles = $objPanier->calculerQteLivre();
$sousTotal = $objPanier->calculerSousTotal();


//Ici on récupère la langue dans la "querystring"
$objTpl->langue =  $strLangue ;


try {
    $objPdoConnexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);//On enlève les exception de PDO pour la lancer nous-même avec un msg en français

    //***************************************************************************** :)
    // 1) Tous les requêtes pour afficher le contenu

    //****************************************************************
    // A) Requête pour les infos du livre
    // (titre, sous-titre, prix,description, nbre_page, autre catégorie, isbn, annee_publication)
    //****************************************************************
    $strSQLinfoLivre = 'SELECT titre_livre, sous_titre_livre, prix, description_livre, nbre_pages, autres_caracteristiques, isbn, annee_publication
                    FROM t_livre  WHERE isbn=:isbn';

    //Exécution de la requête
    $resultatLivre = $objPdoConnexion->prepare($strSQLinfoLivre);
    $resultatLivre->bindValue('isbn', $isbn, PDO::PARAM_INT);
    $resultatLivre->execute();


    if ($resultatLivre->errorCode() <> '00000') {
        //echo "La requête des livres est donc en erreur";
        //Ici, nous lançons manuellement l'erreur afin de pouvoir avoir directement un message en français. Préalable d'avoir rendu silenceux avant (1ere ligne du try).
        $strMessage = "Les informations du livre n'ont pu être affichés en raison d'un fort achalandage, veillez réessayer plus tard";
        $except = new Exception($strMessage);

        throw $except;

    } //Sinon, si pas erreur
    else {
        if ($resultatLivre->execute()) {

            while ($arrLigneLivre = $resultatLivre->fetch()) {

                //****************************************************************
                // B) Requête pour la collection du livre (nom collection)
                //****************************************************************
                $strSQLCollection = 'SELECT nom_collection
                    FROM t_collection RIGHT JOIN t_livre  ON t_collection.id_collection = t_livre.id_livre
                    WHERE isbn=:isbn';

                //Exécution de la requête
                $resultatCollection = $objPdoConnexion->prepare($strSQLCollection);
                $resultatCollection->bindValue('isbn', $isbn, PDO::PARAM_INT);
                $resultatCollection->execute();

                //S'il y a une erreur d'exception
                if ($resultatCollection->errorCode() <> '00000') {
                    //echo "La requête des livres est donc en erreur";
                    //Ici, nous lançons manuellement l'erreur afin de pouvoir avoir directement un message en français. Préalable d'avoir rendu silenceux avant (1ere ligne du try).
                    $strMessage = "Les informations du livre n'ont pu être affichés en raison d'un fort achalandage, veillez réessayer plus tard";
                    $except = new Exception($strMessage);

                    throw $except;
                } else {
                    while ($arrLigneCollection = $resultatCollection->fetch()) {
                        $strCollection = $arrLigneCollection['nom_collection'];
                    }
                    //Libération de la requête
                    $resultatCollection->closeCursor();

                }  // Fin requete B) - collection ***************************************************


                //****************************************************************
                // C) Requête pour les catégories du livre
                //****************************************************************
                // Requete de catégorie selon la langue
                $strSQLCategorie = 'SELECT ti_categorie_livre.id_categorie, nom_fr, nom_en
                                    FROM (t_categorie INNER JOIN ti_categorie_livre ON ti_categorie_livre.id_categorie = t_categorie.id_categorie)INNER JOIN 
                                    t_livre ON t_livre.id_livre = ti_categorie_livre.id_livre
                                    WHERE isbn=:isbn';

                //Exécution de la requête
                $resultatCategorie = $objPdoConnexion->prepare($strSQLCategorie);
                $resultatCategorie->bindValue('isbn', $isbn, PDO::PARAM_INT);
                $resultatCategorie->execute();

                //S'il y a une erreur d'exception
                if ($resultatCategorie->errorCode() <> '00000') {
                    //echo "La requête des livres est donc en erreur";
                    //Ici, nous lançons manuellement l'erreur afin de pouvoir avoir directement un message en français. Préalable d'avoir rendu silenceux avant (1ere ligne du try).
                    $strMessage = "Les informations du livre n'ont pu être affichés en raison d'un fort achalandage, veillez réessayer plus tard";
                    $except = new Exception($strMessage);
                } else {
                    while ($arrLigneCategorie = $resultatCategorie->fetch()) {

                        if ($strLangue == 'en') {
                            $arrCategories[] = array(
                                'nom_categorie' => $arrLigneCategorie['nom_en'],
                                'id_categorie' => $arrLigneCategorie['id_categorie']
                            );
                        } else {
                            $arrCategories[] = array(
                                'nom_categorie' => $arrLigneCategorie['nom_fr'],
                                'id_categorie' => $arrLigneCategorie['id_categorie']
                            );
                        }
                    }
                    //Libération de la requête
                    $resultatCategorie->closeCursor();

                } // Fin requete C) - catégorie ***************************************************


                //****************************************************************
                // D) Requête pour les éditeurs du livre (nom_editeur et url_editeur)
                //****************************************************************
                $strSQLEditeur = 'SELECT nom_editeur, url_editeur FROM (t_editeur RIGHT JOIN ti_editeur_livre ON t_editeur.id_editeur = ti_editeur_livre.id_editeur) 
                                  INNER JOIN t_livre ON t_livre.id_livre = ti_editeur_livre.id_livre
                                  WHERE isbn=:isbn';

                //Exécution de la requête
                $resultatEditeur = $objPdoConnexion->prepare($strSQLEditeur);
                $resultatEditeur->bindValue('isbn', $isbn, PDO::PARAM_INT);
                $resultatEditeur->execute();

                //S'il y a une erreur d'exception
                if ($resultatEditeur->errorCode() <> '00000') {
                    //echo "La requête des livres est donc en erreur";
                    //Ici, nous lançons manuellement l'erreur afin de pouvoir avoir directement un message en français. Préalable d'avoir rendu silenceux avant (1ere ligne du try).
                    $strMessage = "Les informations du livre n'ont pu être affichés en raison d'un fort achalandage, veillez réessayer plus tard";
                    $except = new Exception($strMessage);
                } else {
                    while ($arrLigneEditeur = $resultatEditeur->fetch()) {

                        $arrEditeurs[] = array(
                            'nom_editeur' => $arrLigneEditeur['nom_editeur']
                        );

                    }
                    //Libération de la requête
                    $resultatEditeur->closeCursor();
                }

                //****************************************************************
                // E) Requête pour les honneurs du livre (nom_honneur, description_honneur)
                //****************************************************************
                $strSQLHonneur = 'SELECT nom_honneur, description_honneur 
                                  FROM (t_honneur INNER JOIN ti_honneur_livre ON t_honneur.id_honneur = ti_honneur_livre.id_honneur ) RIGHT JOIN t_livre ON t_livre.id_livre = ti_honneur_livre.id_livre
                                  WHERE isbn= :isbn';

                //Exécution de la requête
                $resultatHonneur = $objPdoConnexion->prepare($strSQLHonneur);
                $resultatHonneur->bindValue('isbn', $isbn, PDO::PARAM_INT);
                $resultatHonneur->execute();

                //S'il y a une erreur d'exception
                if ($resultatHonneur->errorCode() <> '00000') {
                    //echo "La requête des livres est donc en erreur";
                    //Ici, nous lançons manuellement l'erreur afin de pouvoir avoir directement un message en français. Préalable d'avoir rendu silenceux avant (1ere ligne du try).
                    $strMessage = "Les informations du livre n'ont pu être affichés en raison d'un fort achalandage, veillez réessayer plus tard";
                    $except = new Exception($strMessage);
                } else {
                    while ($arrLigneHonneur = $resultatHonneur->fetch()) {

                        $arrHonneurs[] = array(
                            'nom_honneur' => $arrLigneHonneur['nom_honneur'],
                            'description_honneur' => $arrLigneHonneur['description_honneur']
                        );

                    }
                    //Libération de la requête
                    $resultatHonneur->closeCursor();
                }


                //****************************************************************
                // F) Requête pour les recensions (date, titre, nom_media, nom_journalisme, description)
                //****************************************************************
                $strSQLRecension = 'SELECT date_recension, titre_recension, nom_media, nom_journaliste, description_recension
                                    FROM t_recension RIGHT JOIN t_livre ON t_livre.id_livre = t_recension.id_recension
                                    WHERE isbn =:isbn ';

                //Exécution de la requête
                $resultatRecension = $objPdoConnexion->prepare($strSQLRecension);
                $resultatRecension->bindValue('isbn', $isbn, PDO::PARAM_INT);
                $resultatRecension->execute();

                //S'il y a une erreur d'exception
                if ($resultatRecension->errorCode() <> '00000') {
                    //echo "La requête des livres est donc en erreur";
                    //Ici, nous lançons manuellement l'erreur afin de pouvoir avoir directement un message en français. Préalable d'avoir rendu silenceux avant (1ere ligne du try).
                    $strMessage = "Les informations du livre n'ont pu être affichés en raison d'un fort achalandage, veillez réessayer plus tard";
                    $except = new Exception($strMessage);
                } else {
                    while ($arrLigneRecension = $resultatRecension->fetch()) {

                        $arrRecension[] = array(
                            'date_recension' => new DateTime($arrLigneRecension['date_recension']),
                            'titre_recension' => $arrLigneRecension['titre_recension'],
                            'nom_media' => $arrLigneRecension['nom_media'],
                            'nom_journaliste' => $arrLigneRecension['nom_journaliste'],
                            'description_recension' => $arrLigneRecension['description_recension']
                        );

                    }
                    //Libération de la requête
                    $resultatRecension->closeCursor();
                }

                //****************************************************************
                // G) Requête pour les auteur (nom, biographie, url_blogue)
                //****************************************************************

                $arrAuteurs = array(
                    'info_auteur' => tranformerAuteur($objPdoConnexion, $isbn)
                );

                // Mettre tout les infos dans le tableau livre *******************************************************
                $arrLivres[] = array(
                    'titre_livre' => ameliorerTitre($arrLigneLivre['titre_livre']),
                    'sous_titre_livre' => $arrLigneLivre['sous_titre_livre'],
                    'prix' => $arrLigneLivre['prix'],
                    'description_livre' => $arrLigneLivre['description_livre'],
                    'nbre_pages' => $arrLigneLivre['nbre_pages'],
                    'autres_caracteristiques' => $arrLigneLivre['autres_caracteristiques'],
                    'isbn' => $arrLigneLivre['isbn'],
                    'annee_publication' => $arrLigneLivre['annee_publication'],
                    'nom_collection' => $strCollection,
                    'categorieMultiple' => $arrCategories,
                    'editeurMultiple' => $arrEditeurs,
                    'honneurMultiple' => $arrHonneurs,
                    'infosRecension' => $arrRecension,
                    'auteurMultiple' => $arrAuteurs['info_auteur']
                );
            }

            //Libération de la requête
            $resultatLivre->closeCursor();
        }
    }


    //***************************************************************************** :)
    // 2) La logique pour la section des avis

    //Détermine le nombre d'avis
    $intNbrAvis = rand(3, 15); // de 3 a 15 avis

    $intCpt = 0;
    //Tiré au hasard parmi les avis
    while ($intCpt < 3) {

        //_Tirer nombre d'avis au hasard

        $intIndexHazard = rand(0, (count($arrAvisDisponible) - 1));
        //Prendre la suggestion et la mettre dans les artistes choisis
        array_push($arrAvisChoisi, $arrAvisDisponible[$intIndexHazard]);
        //Enlever la suggestion des sugessions disponible (Évite les suggestion doublons)
        array_splice($arrAvisDisponible, $intIndexHazard, 1);

        //tirer date au hasars
        $arrDateHasard[$intCpt] = new DateTime("2018-" . rand(1, 11) . "-" . rand(1, 31));

        $intCpt++;
    }
    //Trié le tableau de dates
    rsort($arrDateHasard);
    //var_dump($arrDateHasard);

    //Mettre dans tableau les infos tirés
    $arrInfoAvisChoisi = array();
    for ($intCpt = 0; count($arrAvisChoisi) > $intCpt; $intCpt++) {

        $arrDateHasard[$intCpt]->format('d-m-Y');

        if (isset($decode_json['avis' . $arrAvisChoisi[$intCpt]]['image'])) {
            $imageUtilisateur = $decode_json['avis' . $arrAvisChoisi[$intCpt]]['image'];
        } else {
            //Mettre l'image par défault
            $imageUtilisateur = "antoine1.jpg";
        }

        // Tableau des avis tirés au hasard
        $arrInfoAvisChoisi[$intCpt] = array(
            'nomUtilisateur' => $decode_json['avis' . $arrAvisChoisi[$intCpt]]['nom'],
            'avis' => $decode_json['avis' . $arrAvisChoisi[$intCpt]]['avis'],
            'nbrEtoile' => $decode_json['avis' . $arrAvisChoisi[$intCpt]]['etoiles'],
            'date' => $arrDateHasard[$intCpt],
            'image' => $imageUtilisateur,
        );


    }
    //var_dump($arrInfoAvisChoisi);

    // Mettre tout les infos avis dans un tableau
    $arrTousInfoAvis[] = array(
        'nbrAvis' => $intNbrAvis,
        'nomUtilisateur' => $decode_json['avis1']['nom'],
        'avis' => $decode_json['avis1']['avis'],
        'nbrEtoile' => $decode_json['avis1']['etoiles'],
        'avisMultiple' => $arrInfoAvisChoisi
    );


    //***************************************************************************** :)
    // 2) Code pour la logique du panier

    // ajouterLivre($objPdoConnexion, $isbn);
    if (isset($_GET['btnAjouter'])) {
        //Si la quantité est plus grand zero
        if ($_GET['quantiteLivre'] > 0) {
            $objPanier->ajouterLivre($objPdoConnexion, $isbn, $_GET['quantiteLivre']);

            //maj $objPanier
            $_SESSION['panier'] = serialize($objPanier);


            $qteTotalAticles = $objPanier->calculerQteLivre();

            //Activé la rétroaction du panier
            $X = '<form action="fiche.php" class="frmRetroAjoutPanier"><input type="hidden" name="isbn" value="' . $isbn . '"><button class="ctrlPanier__X">X</button></form>';

            //Image du livre ajouté
            if (file_exists($strNiveau . "assets/images/couvertures/L" . ISBNToEAN($arrLivres[0]['isbn']) . "1.jpg")) {
                $imageLivre = '<img class="retroImgLivre" src= " ' . $strNiveau . "assets/images/couvertures/L" . ISBNToEAN($arrLivres[0]['isbn']) . "1.jpg" . '">';
            }
            else{
                $imageLivre = '<img class="retroImgLivre livreSansCouverture" src= " ' . $strNiveau . 'assets/images/couvertures/cover.png">';
            }

            // HTML de la rétroaction du panier
            $retroPanier = '<div class="ctrlPanier__retroaction" id="ctrlPanier__retroaction">'
                . $imageLivre . '
            <p class="pNoir">Vous venez d\'ajouter à votre panier: ('. $_GET["quantiteLivre"] .')</p>
            <p><cite>' . $arrLivres[0]['titre_livre'] . '</cite> </p>
            <p><span class="pNoir">Sous-total  </span>(' . $qteTotalAticles . ' articles) : ' . $sousTotal . '$</p> 
            <p class="lienBouton" ><a href="../transaction/panier.php">Voir mon panier</a></p>
            <p class="lienBouton"><a href="../connexion.php">Passer la commande</a></p>
      </div> 
  ';
        } else {
            $X = "";
            $retroPanier = "";
        }
    } else {
        $X = "";
        $retroPanier = "";
    }


}// Fin du try .... ajout exe 8
catch (Exception $e) {
    $objTpl->erreur = $e->getMessage();  //Le message gentil en FRANÇAIS destiné à l'usager du site sera envoyé au template pour le saupoudrage.
}


// Instancier, configurer et afficher le template
$objTpl->livres = $arrLivres;
$objTpl->niveau = $strNiveau;
$objTpl->avis = $arrTousInfoAvis;
$objTpl->mois = $arrMois;
$objTpl->filAriane = $objTpl->fetch('partials/fil-ariane.tpl.php');
$objTpl->qteItemDiffPanier = $objPanier->calculerQteLivreDiff();
$objTpl->sousTotal = $objPanier->calculerSousTotal();
//retroaction panier
$objTpl->nombreArticles = $objPanier->calculerQteLivre();
$objTpl->x = $X;
$objTpl->retroPanier = $retroPanier;

$objTpl->display('fiche.tpl.php');