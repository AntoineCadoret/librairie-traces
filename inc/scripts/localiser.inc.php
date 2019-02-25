<?php
/**
 * @auteur Michaël Croteau <mickeycroteau@gmail.com>
 */

if (isset($_GET['lang'])) {
    if ($_GET['lang'] == "fr") {
        $strLangue = 'fr';
        $strLocale = 'fr_CA.utf8';
        setcookie('langue', $strLangue);
        setcookie('locale', $strLocale);

    } else if ($_GET['lang'] == "en") {
        $strLangue = 'en';
        $strLocale = 'en_CA.utf8';
        setcookie('langue', $strLangue);
        setcookie('locale', $strLocale);
    }
} else {
    // s'il y a un cookie prendre la valeur du cookie
    if (isset($_COOKIE['langue'])) {
        $strLangue = $_COOKIE['langue'];
        $strLocale = $_COOKIE['locale'];
    } //sinon FRANÇAIS par défaut
    else {
        $strLangue = 'fr';
        $strLocale = 'fr_CA.utf8';
    }
}


//Définir le nom des fichiers .po se trouvant dans le répertoire $strLocale
$strNomFichier = 'default';

// Garder en commentaire la ligne suivante - http://ca3.php.net/manual/fr/function.putenv.php
putenv("LC_ALL=$strLocale");

// setlocale — Modifie les informations de localisation - http://ca3.php.net/manual/fr/function.setlocale.php
setlocale(LC_ALL, $strLocale);
// bindtextdomain — Fixe le chemin d'un domaine
bindtextdomain($strNomFichier, $strNiveau . 'locale');
// bind_textdomain_codeset — Spécifie le jeu de caractères utilisé pour les messages du domaine DOMAIN
bind_textdomain_codeset($strNomFichier, "UTF-8");
// textdomain — Fixe le domaine par défaut
textdomain($strNomFichier);