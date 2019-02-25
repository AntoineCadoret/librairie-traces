<?php
/**
 * @author XYZ <XYZ@cegep-ste-foy.qc.ca>
 * @copyright Copyright (c)2015 – Cégep de sainte-Foy
 * Date: 2018-10-5
 * Le fichier de configuration s'occupe de:
 * - centraliser les paramètres du site comme la connexion à la BD
 * - définir un gestionnaire d'erreurs
 * - définir des fonctions utilitaires pour le déboguage et pour la sécurité (échapper les données client)
 */

// DEBUT Paramètres du site

// personne responsable des bogues (gestion des erreurs)
// nota bene: les envois de courriels sur timunix n'ont fonctionné qu'avec les adresses ...@cegep-ste-foy.qc.ca
$strCourrielContact= ''; //VOTRE adresse d'étudiant(e) courriel VALIDE. Sinon, à répétition, cela bloque le serveur de courriel du cegep entier!

error_reporting(E_ALL | E_STRICT);

// Verifier si l'exécution se fait sur le serveur de développement (local) ou celui de la production:
if (stristr($_SERVER['HTTP_HOST'], 'local') || (substr($_SERVER['HTTP_HOST'], 0, 7) == '192.168')) {
    $blnLocal = TRUE;
} else {
    $blnLocal = FALSE;
}

/**
 * Selon l'environnement d'exécution (développement ou hébergement)
 * @todo Adapter les variables de connexion des 2 environnements
 */
if ($blnLocal) {
    $strHost = "localhost";
    $strUser = "root";
    $strPassword = "root";
    $strBD = "18_pni3_3petitsb";
} else {
    $strHost = 'timunix2.cegep-ste-foy.qc.ca'; //Les configs de timunix2 sont à vérifier
    $strUser = '18_pni3_3petitsb';
    $strPassword = 'timfactory';
    $strBD = '18_pni3_3petitsb';
}

//Data Source Name pour l'objet PDO
$strDsn = 'mysql:dbname=' . $strBD . ';host=' . $strHost;

//Tentative de connexion
$objPdoConnexion = new PDO($strDsn, $strUser, $strPassword);

//Changement d'encodage de l'ensemble des caractères pour UTF-8
$objPdoConnexion->exec("SET CHARACTER SET utf8");

//Pour obtenir des rapports d'erreurs et d'exception avec errorInfo()
$objPdoConnexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//$objPdoConnexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);

// DEBUT Gestion des erreurs et fonctions utilitaires
// (réglages pour le développement ou l'hébergement)

if ($blnLocal) {
    // (réglages pour le DÉVELOPPEMENT)
    // Affiche toutes les Errors, warnings, notices et syntaxes dépréciées
    error_reporting(E_ALL | E_STRICT);
    ini_set('display_errors', true); // Modification de la configuration du fichier ini
} else {
    ini_set('display_errors', false); // Rendu à l'hébergement, on ne veut pas que le client voit les messages d'erreurs!!
}

// Pour pouvoir utiliser de  manière fiable la fonction date(), dans le gestionnaire d'erreurs, il faut spécifier le fuseau horaire.
date_default_timezone_set('America/Montreal');

/**
 * Creer le gestionnaire d'erreurs
 * @param $e_number
 * @param $e_message
 * @param $e_file
 * @param $e_line
 * @param $e_vars
 * @return void
 */
function gererErreurs ($e_number, $e_message, $e_file, $e_line, $e_vars) {
    // Construire le message d'erreur
    $strMessage = "Une erreur est survenue dans le script '$e_file' a la ligne $e_line: \n<br />$e_number : $e_message\n<br />";
    // Ajouter la date et l'heuregit
    $strMessage .= "Date/Time: " . date('n-j-Y H:i:s') . "\n<br />";
    // Ajouter $e_vars au $message.
    $strMessage .= "<pre>" . print_r ($e_vars, 1) . "</pre>\n<br />";
    // On peut aussi créer un journal d'erreurs et/ou envoyer par courriel.
    //@todo ramener la gestion selon $blnLocal. C'est fait.
    if ($GLOBALS['blnLocal']) {
        echo '<p class="error">' . $strMessage . '</p>';
        //error_log ($strMessage, 3, "log-err.txt"); //Journalisation possible des erreurs dans un fichier log-err.txt
    } else {
        // En production, on voudrait seulement un courriel.
        //error_log ($strMessage, 1, $GLOBALS['courrielContact']); //Envoi de tous les erreurs par courriel
		echo '<p class="error">' . $strMessage . '</p>'; //Affichage temporaire pour voir aussi les erreurs sur timunix2 (sera retiré ensuite).
    }
    
}
// Utiliser le gestionnaire d'erreurs:
set_error_handler ('gererErreurs');
