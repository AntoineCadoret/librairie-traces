<?php

class Panier
{
    protected $_arrPanier = array();

    //Définition des propriétés

    public function ajouterLivre($connexion, $isbn, $quantite)
    {
        //****************************************************************
        // Aller chercher les informations du livre à stocker
        //****************************************************************
        $strSQLinfoPanier = 'SELECT titre_livre, prix
                    FROM t_livre  WHERE isbn=:isbn';

        //Exécution de la requête
        $resultatPanier = $connexion->prepare($strSQLinfoPanier);
        $resultatPanier->bindValue('isbn', $isbn, PDO::PARAM_INT);
        $resultatPanier->execute();

        //****************************************************************
        // G) aller chercher les auteurs du livres  (nom)
        //****************************************************************
        $strSQLinfoAuteur = 'SELECT nom_auteur
                                     FROM (t_auteur INNER JOIN ti_auteur_livre ON t_auteur.id_auteur = ti_auteur_livre.id_auteur) INNER JOIN t_livre ON t_livre.id_livre = ti_auteur_livre.id_livre  
                                     WHERE isbn=:isbn';

        //Exécution de la requête
        $resultatAuteur = $connexion->prepare($strSQLinfoAuteur);
        $resultatAuteur->bindValue('isbn', $isbn, PDO::PARAM_INT);
        $resultatAuteur->execute();

        while ($arrLigneAuteur = $resultatAuteur->fetch()) {
            $arrAuteurs[] = $arrLigneAuteur['nom_auteur'];
        }
        //Libération de la requête
        $resultatAuteur->closeCursor();

        // Mettre dans un tableau les résultats

        //A ajouter ... vérifier si est la ... ajouter +1, sinon ajouter le livre
        while ($arrLignePanier = $resultatPanier->fetch()) {
            $this->_arrPanier[$isbn] = array(
                'titre_livre' => $arrLignePanier['titre_livre'],
                'prix' => number_format($arrLignePanier['prix'], 2, ".", ""),
                'quantite' => $quantite,
                'auteurMultiple' => $arrAuteurs
            );
        }

        //Libération de la requête
        $resultatPanier->closeCursor();

    }

    public function retournerPanier()
    {
        if (isset($this->_arrPanier)) {
            return $this->_arrPanier;
        }
    }

    public function majPanier($isbn, $quantite)
    {

        $this->_arrPanier[$isbn]['quantite'] = $quantite;

    }

    /* Suppression ******************************** */
    public function supprimerLivre($isbn)
    {
        unset($this->_arrPanier[$isbn]);
    }

    public function supprimerToutPanier()
    {
        unset($this->_arrPanier);
    }

    /* Calcule des quantités ************************* */
    public function calculerQteLivreDiff()
    {
        $nombreArticleDiff = count($this->_arrPanier);

        return $nombreArticleDiff;
    }

    public function calculerQteLivre()
    {
        $nombreArticle = 0;

        if (isset($this->_arrPanier)) {
            foreach ($this->_arrPanier as $isbn => $arrPanier) {
                $nombreArticle = $nombreArticle + $arrPanier['quantite'];
            }
        }
        return $nombreArticle;
    }


    /* Calcule des coûts *************************** */
    public function calculerSousTotal()
    {
        $sousTotal = 0;
        if (isset($this->_arrPanier)) {
            foreach ($this->_arrPanier as $isbn => $arrPanier) {
                $sousTotal = $sousTotal + ($arrPanier["quantite"]) * $arrPanier["prix"];
            }
        }

        return number_format($sousTotal, 2, ".", "");
    }

    public function calculerSousTotalItem($isbn, $quantite)
    {
        $totalPrixItem = 0;

        $totalPrixItem = number_format($this->_arrPanier[$isbn]['prix'] * $quantite, 2, ".", "");

        return $totalPrixItem;
    }

    public function calculerTPSDesLivres($sousTotal)
    {
        $TPS = 0;
        $TPS = $sousTotal * 5 / 100;

        //écrire 2 décimals après la virgule
        return number_format($TPS, 2, ".", "");
    }

    public function calculerFraisLivraison($intArticle, $typeLivraison)
    {
        //S'il y a plus d'un item
        if ($intArticle > 0) {
            //Frais de base de 4$ (standar) et 8$ (rapide)
            $intFraisBase = 4;
            if ($typeLivraison == 'rapide') {
                $intFraisBase = 8;
            }

            //Taux de 3,5$ par item (standar) et 4.5$ (rapide)
            $intFraisItem = 3.5 * $intArticle;
            if ($typeLivraison == 'rapide') {
                $intFraisItem = 4.5 * $intArticle;
            }
        } //Sinon s'il y a pas d'item
        else {
            $intFraisBase = 0;
            $intFraisItem = 0;
        }
        //Calculer le frais livraison selon l'item
        $intFraisLivraison = $intFraisBase + $intFraisItem;

        return number_format($intFraisLivraison, 2);
    }

    public function calculerCoutTotal($intSousTotal, $intTPS, $intLivraison)
    {

        $intCoutTotal = $intSousTotal + $intTPS + $intLivraison;

        return number_format($intCoutTotal, 2, ".", "");
    }


    /* Calculer la date de livraison estimé (petit ajout) *************************** */
    public function estimerDateLivraison($typeLivraison, $dateAujourdhui, $arrMois)
    {
        //Livraison standar = 2 semaines (14 jours) et livraison rapide 3 jours
        if ($typeLivraison == 'standard') {
            $dateLivraison = $dateAujourdhui->add(new DateInterval('P14D'));
        } else {
            if ($typeLivraison == 'rapide') {
                $dateLivraison = $dateAujourdhui->add(new DateInterval('P3D'));
            }
        }

        // Convertir la date en bon format
        $dateLivraison = $dateLivraison->format('j') . " "  . $arrMois[$dateLivraison->format('n')-1] . " " . $dateLivraison->format('Y');

        return $dateLivraison;
    }


}

?>