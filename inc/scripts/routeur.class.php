<?php
/**
 * Created by PhpStorm.
 * User: etu01
 * Date: 18-11-08
 * Time: 09:57
 */
class routeur
{
    private $arrTransaction;
    public function chercherInfo($courriel, $objPdoConnexion)
    {
            $strRequeteClient = "SELECT id_client, prenom_client, nom_client, telephone_client FROM t_client WHERE courriel_client = :courriel";
            $resultatClient = $objPdoConnexion->prepare($strRequeteClient);
            $resultatClient->bindValue('courriel', $courriel);
            $resultatClient->execute();
            $arrLigneClient = $resultatClient->fetch();
            $this->arrTransaction['clients'] = array(
                'prenom_client' => $arrLigneClient['prenom_client'],
                'nom_client' => $arrLigneClient['nom_client'],
                'id_client' => $arrLigneClient['id_client'],
                'telephone_client' => $arrLigneClient['telephone_client'],
                'courriel_client' => $courriel
            );
            $strRequeteLivraison = "SELECT prenom_adresse, nom_adresse, adresse, ville, code_postal, nom_province FROM t_adresse INNER JOIN t_province ON t_adresse.abbr_province = t_province.abbr_province WHERE type_adresse = :adresse AND id_client = :id";
            $resultatLivraison = $objPdoConnexion->prepare($strRequeteLivraison);
            $resultatLivraison->bindValue('id', $this->arrTransaction['clients']['id_client'], PDO::PARAM_INT);
            $resultatLivraison->bindValue('adresse', 'livraison');
            $resultatLivraison->execute();
            $arrLigneLivraison = $resultatLivraison->fetch();
            $this->arrTransaction['adresseLivraison'] = array(
                'prenom_adresse' => $arrLigneLivraison['prenom_adresse'],
                'nom_adresse' => $arrLigneLivraison['nom_adresse'],
                'adresse' => $arrLigneLivraison['adresse'],
                'ville' => $arrLigneLivraison['ville'],
                'code_postal' => $arrLigneLivraison['code_postal'],
                'nom_province' => $arrLigneLivraison['nom_province']
            );
            $strRequeteFacturation = "SELECT prenom_adresse, nom_adresse, adresse, ville, code_postal, nom_province FROM t_adresse INNER JOIN t_province ON t_adresse.abbr_province = t_province.abbr_province WHERE type_adresse = :adresse AND id_client = :id";
            $resultatFacturation = $objPdoConnexion->prepare($strRequeteFacturation);
            $resultatFacturation->bindValue('id', $this->arrTransaction['clients']['id_client'], PDO::PARAM_INT);
            $resultatFacturation->bindValue('adresse', 'facturation');
            $resultatFacturation->execute();
            $arrLigneFacturation = $resultatFacturation->fetch();
            $this->arrTransaction['adresseFacturation'] = array(
                'prenom_adresse' => $arrLigneFacturation['prenom_adresse'],
                'nom_adresse' => $arrLigneFacturation['nom_adresse'],
                'adresse' => $arrLigneFacturation['adresse'],
                'ville' => $arrLigneFacturation['ville'],
                'code_postal' => $arrLigneFacturation['code_postal'],
                'nom_province' => $arrLigneFacturation['nom_province']
            );
            $strRequetePaiement = "SELECT est_paypal, nom_complet, no_carte, type_carte, date_expiration_carte, code FROM t_mode_paiement WHERE id_client = :id";
            $resultatPaiement = $objPdoConnexion->prepare($strRequetePaiement);
            $resultatPaiement->bindValue('id', $this->arrTransaction['clients']['id_client'], PDO::PARAM_INT);
            $resultatPaiement->execute();
            $arrLignePaiement = $resultatPaiement->fetch();
            $this->arrTransaction['mode_paiement'] = array(
                'est_paypal' => $arrLignePaiement['est_paypal'],
                'nom_complet' => $arrLignePaiement['nom_complet'],
                'no_carte' => $this->modifierNumCarte($arrLignePaiement['no_carte']),
                'type_carte' => $arrLignePaiement['type_carte'],
                'date_expiration_carte' => $arrLignePaiement['date_expiration_carte'],
                'code' => $arrLignePaiement['code']
            );
            return $this->arrTransaction;

    }
    public function ajouterMembre($arrNouveauMembre, $objPdoConnexion){

        $strAjouterMembre= "INSERT INTO t_client VALUES :prenom, :nom, :courriel, :telephone, :motPasse";
        $resultatAjoutMembre = $objPdoConnexion->prepare($strAjouterMembre);
        $resultatAjoutMembre->bindValue('prenom', $arrNouveauMembre['client']['prenom']);
        $resultatAjoutMembre->bindValue('nom', $arrNouveauMembre['client']['nom']);
        $resultatAjoutMembre->bindValue('courriel', $arrNouveauMembre['client']['courriel']);
        $resultatAjoutMembre->bindValue('telephone', $arrNouveauMembre['client']['telephone']);
        $resultatAjoutMembre->bindValue('motPasse', $arrNouveauMembre['client']['motPasse']);
        //$resultatAjoutMembre->execute();
        $idClient= $this->trouverId($arrNouveauMembre['client']['prenom'], $arrNouveauMembre['client']['nom'], $objPdoConnexion);

        $strAjouterLivraison = "INSERT INTO t_adresse VALUES (:prenom, :nom, :adresse, :ville, :codePostal, 1, livraison, :abbr_province, id_client)";
        $resultatAjoutLivraison = $objPdoConnexion->prepare($strAjouterLivraison);
        $resultatAjoutLivraison->bindValue('prenom', $arrNouveauMembre['livraison']['prenom_livraison']);

        $resultatAjoutLivraison->bindValue('nom', $arrNouveauMembre['livraison']['nom_livraison']);
        $resultatAjoutLivraison->bindValue('adresse', $arrNouveauMembre['livraison']['adresse_livraison']);
        $resultatAjoutLivraison->bindValue('ville', $arrNouveauMembre['livraison']['ville_livraison']);
        $resultatAjoutLivraison->bindValue('codePostal', $arrNouveauMembre['livraison']['codePostal_livraison']);
        $resultatAjoutLivraison->bindValue('abbr_province', $arrNouveauMembre['livraison']['province_livraison']);
        $resultatAjoutLivraison->bindValue('id_client', $idClient);
        //$resultatAjoutLivraison->execute();

        $strAjouterFacturation = "INSERT INTO t_adresse VALUES (:prenom, :nom, :adresse, :ville, :codePostal, 1, facturation, :abbr_province, id_client)";
        $resultatAjoutFacturation = $objPdoConnexion->prepare($strAjouterFacturation);
        $resultatAjoutFacturation->bindValue('prenom', $arrNouveauMembre['facturation']['prenom_facturation']);
        $resultatAjoutFacturation->bindValue('nom', $arrNouveauMembre['facturation']['nom_facturation']);
        $resultatAjoutFacturation->bindValue('adresse', $arrNouveauMembre['facturation']['adresse_facturation']);
        $resultatAjoutFacturation->bindValue('ville', $arrNouveauMembre['facturation']['ville_facturation']);
        $resultatAjoutFacturation->bindValue('codePostal', $arrNouveauMembre['facturation']['codePostal_facturation']);
        $resultatAjoutFacturation->bindValue('abbr_province', $arrNouveauMembre['facturation']['province_facturation']);
        $resultatAjoutFacturation->bindValue('id_client', $idClient);
        //$resultatAjoutFacturation->execute();

        if($arrNouveauMembre['est_paypal'] == 0) {
            $strAjoutPaiement = "INSERT INTO t_mode_de_paiement VALUES (0, :nomComplet, :no_carte, :type_carte, date_expiration, :code, 1, id_client)";
            $resultatAjoutPaiement = $objPdoConnexion->prepare($strAjoutPaiement);
            $resultatAjoutPaiement->bindValue('nomComplet', $arrNouveauMembre['mode_paiement']['nom_complet']);
            $resultatAjoutPaiement->bindValue('no_carte', $arrNouveauMembre['mode_paiement']['no_carte']);
            $resultatAjoutPaiement->bindValue('type_carte', $arrNouveauMembre['mode_paiement']['type_carte']);
            $resultatAjoutPaiement->bindValue('date_expiration', $arrNouveauMembre['mode_paiement']['date_expiration']);
            $resultatAjoutPaiement->bindValue('code', $arrNouveauMembre['mode_paiement']['code']);
            $resultatAjoutPaiement->bindValue('id_client', $idClient);
            //$resultatAjoutPaiement->execute();
        }
        else
        {
            $strAjoutPaiement = "INSERT INTO t_mode_paiement(est_paypal, nom_complet, est_defaut, id_client) VALUES (1, :nomComplet, 1, :id_client)";
            $resultatAjoutPaiement = $objPdoConnexion->prepare($strAjoutPaiement);
            $resultatAjoutPaiement->bindValue('nomComplet', $arrNouveauMembre['mode_paiement']['nom_complet']);
            $resultatAjoutPaiement->bindValue('id_client', $idClient);
            //$resultatAjoutPaiement->execute();

        }
        $arrNouveauMembre['id_client'] = $idClient;
    }
    private function trouverId($prenom, $nom , $objPdoConnexion){
        $strTrouverId = "SELECT id_client FROM t_client WHERE prenom_client=:prenom AND nom_client=:nom";
        $resultatId = $objPdoConnexion->prepare($strTrouverId);
        $resultatId->bindValue('prenom', $prenom);
        $resultatId->bindValue('nom', $nom);
        $resultatId->execute();
        $arrLigne = $resultatId->fetch();
        $id_client =$arrLigne['id_client'];
        return $id_client;
    }
    public function chercherMotPasse($courriel, $objPdoConnexion){
        $strMotPasse = "SELECT mot_de_passe FROM t_client WHERE courriel_client=:courriel";
        $resultatMotPasse = $objPdoConnexion->prepare($strMotPasse);
        $resultatMotPasse->bindValue('courriel', $courriel);
        $resultatMotPasse->execute();
        $arrLigneMotPasse = $resultatMotPasse->fetch();
        $motPasse = $arrLigneMotPasse['mot_de_passe'];
        return $motPasse;
    }
    private function modifierNumCarte($numeroCarte){
        $motPourCacher="XXXXXXXXXXXX";
        $numeroCache=substr_replace($numeroCarte, $motPourCacher, 0,12);
        return $numeroCache;
    }
    public function trouverAbbrProvince($nomProvince,$objPdoConnexion){
        $province= substr($nomProvince, 0, -2);
        $strRequeteProvince="SELECT abbr_province FROM t_province WHERE nom_province=:nom";
        $resultatAbbrProvince = $objPdoConnexion->prepare($strRequeteProvince);
        $resultatAbbrProvince->bindValue('nom', $province);
        $resultatAbbrProvince->execute();
        $arrLigneProvince = $resultatAbbrProvince->fetch();
        $abbrProvince = $arrLigneProvince['abbr_province'];
        return  $abbrProvince;
    }
    public function detruireSession(){
        $_SESSION = session_destroy();
    }
}
?>