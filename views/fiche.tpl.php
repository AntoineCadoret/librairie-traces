<!DOCTYPE HTML>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <?php foreach ($this->livres as $arrLivre): ?>
        <title>
            Librairie Traces - <?php echo $arrLivre['titre_livre']; ?>
        </title>
    <?php endforeach; ?>
    <link rel="stylesheet" href="<?php echo $this->niveau . "/assets/css/styles-c.css"; ?>">
</head>
<body>
<a href="#contenu" class="visuallyhidden focusable">Aller au contenu</a>
<?php include($this->niveau . "views/partials/entete.tpl.php"); ?>
<main class="wrap">
    <?php if ($this->erreur == false) { ?>

        <?php echo $this->filAriane; ?>
        <?php foreach ($this->livres as $arrLivre): ?>
            <h1 id="titre"><?php echo $arrLivre['titre_livre']; ?></h1>
            <h2 class="texteRouge"><?php echo $arrLivre['sous_titre_livre']; ?></h2>
            <h2 class="texteRouge auteur">
                <?php ; ?>
                <ul>
                    <?php foreach ($arrLivre['auteurMultiple'] as $arrAuteur): ?>
                        <li class="liAuteur">
                            <?php echo $arrAuteur['nom_auteur']; ?></li>
                    <?php endforeach; ?>

                </ul>
                <?php ; ?>
            </h2>
            <div class="wrap divInfo section1">

                <div class="divImage">
                    <img
                            src="<?php if (file_exists($this->niveau . "assets/images/couvertures/L" . ISBNToEAN($arrLivre['isbn']) . "1.jpg")) {
                                echo $this->niveau . "assets/images/couvertures/L" . ISBNToEAN($arrLivre['isbn']) . "1.jpg" . '"' . 'class="imgCouverture"';
                            } else {
                                echo $this->niveau . "assets/images/couvertures/cover.png" . '"' . 'class="livreSansImage imgCouverture"';
                            } ?> alt=" Image du livre">
                </div>

                <div class="contenu">
                    <p class="contenu__prixLivre"><?php echo $arrLivre['prix'] . " $"; ?></p>
                    <div>
                        <form class="contenu__formQte" action="fiche.php">
                            <p>
                                <label for="quantiteLivre"><?php echo gettext('Quantité:'); ?></label>
                                <select name="quantiteLivre" id="quantiteLivre">
                                    <option value="0">0</option>
                                    <option value="1" selected>1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                </select>
                            </p>
                            <input hidden name="isbn" class="isbnSent" data-isbn="<?php echo $arrLivre['isbn']; ?>" value="<?php echo $arrLivre['isbn']; ?>">
                            <button type="submit" name="btnAjouter"
                                    class="boutonPrimaire btnAjouter"><?php echo gettext('Ajouter au panier'); ?></button>
                        </form>
                    </div>

                    <section class="sectionOnglet">
                        <!-- la section des 3 onglets -->
                        <howto-tabs aria-label="onglets">
                            <howto-tab role="heading" slot="tab"><?php echo gettext('Description'); ?>
                            </howto-tab>
                            <howto-panel role="region" slot="panel">
                                <p><?php echo $arrLivre['description_livre']; ?></p>
                            </howto-panel>

                            <howto-tab role="heading" slot="tab"><?php echo gettext('Publication'); ?></howto-tab>
                            <howto-panel role="region" slot="panel">
                                <ul class="infoPublication">
                                    <li>
                                        <span class="infoGras"><?php echo gettext('Nombre de pages: '); ?></span><?php echo $arrLivre['nbre_pages']; ?>
                                    </li>
                                    <?php if (isset($arrLivre['nom_collection'])) { ?>
                                        <li>
                                            <span class="infoGras"><?php echo gettext('Collection: '); ?></span><?php echo $arrLivre['nom_collection']; ?>
                                        </li>
                                    <?php } ?>
                                    <li>
                                        <span class="infoGras"><?php echo gettext('Catégorie(s): '); ?></span>
                                        <?php foreach ($arrLivre['categorieMultiple'] as $arrMultiCategories): ?>
                                            <ul>
                                                <li class="liCategories">
                                                    <a href="index.php?categorie=<?php echo $arrMultiCategories['id_categorie']; ?>">
                                                        <?php echo $arrMultiCategories['nom_categorie']; ?>
                                                    </a>
                                                </li>
                                            </ul>
                                        <?php endforeach; ?>
                                    </li>
                                    <li>
                                        <span class="infoGras"><?php echo gettext('Éditeur(s): '); ?></span>
                                        <?php foreach ($arrLivre['editeurMultiple'] as $arrEditeurs): ?>
                                            <span><?php echo $arrEditeurs['nom_editeur'] . " "; ?></span>
                                        <?php endforeach; ?>
                                    </li>
                                    <li>
                                        <span class="infoGras"><?php echo gettext('Année: '); ?></span><?php echo $arrLivre['annee_publication']; ?>
                                    </li>
                                    <li><span class="infoGras">ISBN:</span> <?php echo $arrLivre['isbn']; ?></li>
                                </ul>
                            </howto-panel>

                            <howto-tab role="heading" slot="tab"><?php echo gettext('Auteur'); ?></howto-tab>
                            <howto-panel role="region" slot="panel">
                                <?php foreach ($arrLivre['auteurMultiple'] as $arrAuteur): ?>
                                    <h3><?php echo $arrAuteur['nom_auteur']; ?></h3>
                                    <?php if ($arrAuteur['url_blogue'] != "" || $arrAuteur['url_blogue'] != null) { ?>
                                        <p class="texteRouge"><?php echo gettext('Url du  blogue: '); ?><?php echo $arrAuteur['url_blogue']; ?> </p>
                                    <?php } ?>
                                    <p><?php echo $arrAuteur['biographie']; ?></p>
                                <?php endforeach; ?>
                            </howto-panel>
                        </howto-tabs>
                    </section>
                </div>
            </div>
            <div class="section2">
                <section>
                    <?php foreach ($arrLivre['honneurMultiple'] as $arrHonneurs): ?>
                        <!-- Vérifier s'il a un honneur -->
                        <?php if (count($arrHonneurs['nom_honneur']) > 0) { ?>
                            <h2><?php echo gettext('Honneur: '); ?></h2>
                            <h3><?php echo $arrHonneurs['nom_honneur']; ?></h3>
                            <p><?php echo $arrHonneurs['description_honneur']; ?></p>
                        <?php } ?>
                    <?php endforeach; ?>
                </section>
                <section>
                    <?php foreach ($arrLivre['infosRecension'] as $arrRecension): ; ?>
                        <!-- Vérifier s'il au moins une recension -->
                        <?php if (count($arrRecension['titre_recension']) > 0) { ?>
                            <h2><?php echo gettext('Ce livre a fait parler de lui'); ?></h2>
                            <h3><?php echo $arrRecension['titre_recension']; ?></h3>
                            <p><?php echo $arrRecension['date_recension']->format('d ') . $this->mois[$arrRecension['date_recension']->format('n') - 1] . $arrRecension['date_recension']->format(' Y'); ?></p>
                            <p><?php echo $arrRecension['description_recension']; ?></p>
                            <p><?php echo gettext('Par: '); ?><?php echo $arrRecension['nom_journaliste']; ?></p>
                            <p>Média: <?php echo $arrRecension['nom_media']; ?></p>
                        <?php } ?>
                    <?php endforeach; ?>
                </section>
            </div>
        <?php endforeach; //Fin forEach this->livres ?>


        <?php foreach ($this->avis as $arrTousAvis): ; ?>
            <div class="avis">
                <h2><?php echo gettext('Les avis: '); ?>(<?php echo $arrTousAvis['nbrAvis']; ?>)</h2>
                <div>
                    <?php foreach ($arrTousAvis['avisMultiple'] as $arrAvis): ?>
                        <div class="avis__hautAvis">
                            <img src="<?php echo $this->niveau . "/assets/images/avis/" . $arrAvis['image']; ?>">
                            <div class="contenuAvis">
                                <p class="p_etoile">
                                    <?php for ($intCpt = 0; $intCpt < $arrAvis['nbrEtoile']; $intCpt++) { ?>
                                        <svg class="icone">
                                            <use xlink:href="#etoile"/>
                                        </svg>
                                    <?php } ?>
                                </p>

                                <p><?php echo $arrAvis['nomUtilisateur']; ?></p>
                                <p class="texteRouge"><?php echo $arrAvis['date']->format('j ') . $this->mois[$arrAvis['date']->format('n') - 1] . $arrAvis['date']->format(' Y'); ?></p>
                            </div>
                        </div>
                        <div class="avis__texte">
                            <p><?php echo $arrAvis['avis']; ?></p>
                        </div>
                    <?php endforeach; //Fin forEach this->avisMultiple ?>

                    <?php if ($arrTousAvis['nbrAvis'] > 3) { ?>
                        <p class="voirPlusAvis"><a><?php echo gettext('Voir tous les commentaires'); ?> ▼ </a></p>
                    <?php } ?>
                </div>
            </div>
        <?php endforeach; //Fin forEach this->livres ?>

        <form class="formAvis">
            <h3>Laissez un avis</h3>
            <p>
                Note:
                <span class="lesEtoiles">
                <?php for ($intCpt = 0; $intCpt < 5; $intCpt++) { ?>
                    <svg class="icone">
                        <use xlink:href="#etoileVide"/>
                    </svg>
                <?php } ?>
            </span>
            </p>
            <p>Commentaire: </p>
            <textarea name="textarea"></textarea>
            <button class="btnLien">Envoyer un commentaire</button>
        </form>

    <?php } //Fin du contenu si pas d'erreur d'exception
    //s'il y a une erreur
    else {
        echo "<h3>Erreur: </h3>";
        echo "<p>$this->erreur</p>";

        echo("<p style='background-color: gainsboro; text-align: center; padding: 20px 0'>Voici le bas de page qui s'affiche quoi qu'il arrive! La page ne bloque plus comme avant s'il y a une erreur de communication avec la bd.</p>");
    } ?>

</main>


<?php include($this->niveau . "views/partials/pieddepage.tpl.php") ?>

<!--D'abord charger le polyfill avec un lien conforme à la doc: https://github.com/WebComponents/webcomponentsjs -->
<script src="https://unpkg.com/@webcomponents/webcomponentsjs@2.0.0/webcomponents-bundle.js"></script>

<!-- On charge le fichier principal (main ou app) qui importe la ou les classes et instancie l'app. -->
<script src="<?php echo $this->niveau; ?>node_modules/requirejs/require.js"
        data-main="<?php echo $this->niveau; ?>assets/js/main.js"></script>


<!-- pour le ajax de la retroaction du panier -->

<!--balise script cdn à jour été 2018-->
<script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous">
</script>
<!--balise script pour chargement local de la version installée avec Bower-->
<script>window.jQuery || document.write('<script src="<?php echo $this->niveau;?>node_modules/jquery/dist/jquery.min.js">\x3C/script>')</script>

<script>const strNiveau = "<?php echo $this->niveau;?>";</script>

</body>

</html>