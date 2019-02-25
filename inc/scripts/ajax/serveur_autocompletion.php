<?php
/**
 * @todo améliorer le HTML retourné par le script en ajoutant l'attribut aria-live
 * Note: comme il s'agit d'un contenu vivant non prioritaire, la valeur polite est recommandée
 */
include('../config.inc.php');

sleep(1);
$message = '';

if (isset($_GET['data'])) {
    $message .= '<div class="autocompletion__data" aria-live="assertive"><ul>';

    $keyword = $_GET['data'];

    $requete = 'SELECT titre_livre FROM t_livre WHERE titre_livre LIKE :keyword';
    $resultat_items = $objPdoConnexion->prepare($requete);
    $resultat_items->bindValue(':keyword', $keyword.'%', PDO::PARAM_STR);

    $resultat_items->execute();

    for ($cpt = 0; $cpt < $resultat_items->rowCount(); $cpt++) {

        $ligne = $resultat_items->fetch();

        $message .= '<li>' . $ligne['titre_livre'] . '</li>';
    }
    $message .= '</ul></div>';
    $resultat_items->closeCursor();
    echo $message;
}
?>
