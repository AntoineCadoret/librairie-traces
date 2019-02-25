<!DOCTYPE HTML>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo gettext('Librairie Traces - Catalogue') ?>  </title>
    <link rel="stylesheet" href="<?php echo $this->niveau ?>/assets/css/styles.css">
    <link rel="stylesheet" href="<?php echo $this->niveau ?>/assets/css/styles-b.css">
</head>
<body>
<a href="#contenu" class="visuallyhidden focusable"><?php echo gettext('Aller au contenu'); ?></a>
<?php echo $this->entete ?>


<main class="wrap">
    <?php echo $this->filAriane; ?>
    <afficher-cacher>
        <p slot="titre" class="categorie"><?php echo gettext('Catégorie') ?></p>
        <div class="ctnCategorie">
            <a href="<?php echo "?tri=" . $this->tri ?>"><?php echo gettext('Tout') ?></a>
            <?php foreach ($this->categories as $arrCategorie): ?>
                <a href="<?php echo "?tri=" . $this->tri . "&categorie=" . $arrCategorie['id_categorie'] ?>"><?php echo $arrCategorie['nom_fr']; ?></a>
            <?php endforeach; ?>
        </div>
    </afficher-cacher>

    <form action="<?php echo $this->niveau . "livres/index.php"; ?>" role="form">
        <?php echo '<input type="hidden" name="page" value="' . $this->numeroPage . '">'; ?>
        <label for="nbItems">Nombre d'items par page:</label>
        <select name="nbItems" id="nbItems">
            <option value="4">4</option>
            <option value="8">8</option>
            <option value="16">16</option>
        </select>
        <label for="affichage">Affichage</label>
        <select name="affichage" id="affichage">
            <option value="grille">Grille</option>
            <option value="liste">Liste</option>
        </select><br>
        <label for='tri'><?php echo gettext('Trier par:') ?> </label>
        <select name='tri' id='tri'>
            <option value="AZ" <?php if ($this->tri == "AZ") { ?> selected <?php } ?>><?php echo gettext('A-Z') ?></option>
            <option value="ZA" <?php if ($this->tri == "ZA") { ?> selected <?php } ?>><?php echo gettext('Z-A') ?></option>
            <option value="prixCoissant" <?php if ($this->tri == "prixCoissant") { ?> selected <?php } ?>>$-$$$</option>
            <option value="prixDécroissant" <?php if ($this->tri == "prixDécroissant") { ?> selected <?php } ?>>$$$-$
            </option>
        </select>
        <p>
            <button name="soumission" class="soumission btnLien"><?php echo gettext('Trier') ?></button>
        </p>

    </form>

    <h1><?php echo gettext('Livres') ?><?php if ($this->noPosCategorie != null) {
            echo "->" . $this->categories[$this->noPosCategorie - 1]['nom_fr'];
        } ?></h1>

    <section class="ctnLivre flexbox-1">
        <?php foreach ($this->livres as $arrLivre): ?>
<!--            <div class="livre">-->
                <div class="livre flexbox-2" id="<?php echo $arrLivre['isbn']; ?>">
                    <a class="livre__image flexbox-3" href="<?php echo $this->niveau . "livres/fiche.php?isbn=" . $arrLivre['isbn'] . "&categorie=" . $this->noCategorie; ?>" >
                        <img class=""
                             src="<?php if (file_exists($this->niveau . "assets/images/couvertures/L" . ISBNToEAN($arrLivre['isbn']) . "1.jpg")) {
                                 echo $this->niveau . "assets/images/couvertures/L" . ISBNToEAN($arrLivre['isbn']) . "1.jpg";
                             } else {
                                 echo $this->niveau . "assets/images/couvertures/cover.png";
                             } ?>" alt="Image du livre">
                    </a>
                    <div class="livre__texte">
                        <a class="livre__texte__titre"
                           href="<?php echo $this->niveau . "livres/fiche.php?isbn=" . $arrLivre['isbn'] . "&categorie=" . $this->noCategorie; ?>"><?php echo $arrLivre['titre_livre']; ?></a>
                        <p class="livre__texte__auteur">
                            <?php foreach ($arrLivre['auteurMultiple'] as $arrAuteur): ?>
                                <?php foreach ($arrAuteur['info_auteur'] as $arrNomAuteur): ?>
                                    <?php echo $arrNomAuteur['nom_auteur'] . "<br>" ?>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </p>
                        <p class="livre__texte__prix"><?php echo $arrLivre['prix']; ?>$</p>
                        <button class="btnLien"><?php echo gettext('Ajouter au panier') ?></button>
                    </div>
                </div>
<!--            </div>-->
        <?php endforeach; ?>
    </section>
</main>

<div class="pagination wrap">
    <?php if ($this->numeroPage > 0) { ?>
        <a href="<?php echo "?page=" . 0 . "&tri=" . $this->tri . "&categorie=" . $this->noCategorie; ?>"><?php echo gettext('Premier') ?></a>
    <?php } else { ?>
        <span style="color:#999"><?php echo gettext('Premier') ?></span> <!-- Bouton premier inactif -->
    <?php } ?>

    &nbsp;|&nbsp;

    <?php if ($this->numeroPage > 0) { ?>
        <a href="<?php echo "?page=" . ($this->numeroPage - 1) . "&tri=" . $this->tri . "&categorie=" . $this->noCategorie; ?>"><?php echo gettext('Précédent') ?></a>
    <?php } else { ?>
        <span style="color:#999"><?php echo gettext('Précédent') ?></span><!-- Bouton précédent inactif -->
    <?php } ?>

    &nbsp;|&nbsp;

    <!-- Statut de progression: page 9 de 99 -->
    <?php echo gettext('Page ') . ($this->numeroPage + 1) . gettext(' de  ') . ($this->nombreTotalPages + 1) ?>

    &nbsp;|&nbsp;

    <!-- Si on est pas sur la dernière page et s'il y a plus d'une page -->
    <?php if ($this->numeroPage < $this->nombreTotalPages) { ?>
        <a href="<?php echo "?page=" . ($this->numeroPage + 1) . "&tri=" . $this->tri . "&categorie=" . $this->noCategorie; ?>"><?php echo gettext('Suivant') ?></a>
    <?php } else { ?>
        <span style="color:#999"><?php echo gettext('Suivant') ?></span><!-- Bouton suivant inactif -->
    <?php } ?>

    &nbsp;|&nbsp;

    <?php if ($this->numeroPage < $this->nombreTotalPages) { ?>
        <a href="<?php echo "?page=" . $this->nombreTotalPages . "&tri=" . $this->tri . "&categorie=" . $this->noCategorie; ?>"><?php echo gettext('Dernier') ?></a>
    <?php } else { ?>
        <span style="color:#999"><?php echo gettext('Dernier') ?></span><!-- Bouton dernier inactif -->
    <?php } ?>
</div>


<?php echo $this->pieddepage ?>
<script src="https://unpkg.com/@webcomponents/webcomponentsjs@2.0.0/webcomponents-bundle.js"></script>
<script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>

<!--balise script pour chargement local de la version installée avec Bower-->
<script>window.jQuery || document.write("<script src='<?php echo $this->niveau;?>node_modules/jquery/dist/jquery.min.js>'")</script>


<!-- On charge le fichier principal (main ou app) qui importe la ou les classes et instancie l'app. -->
<script src = "<?php echo $this->niveau; ?>node_modules/requirejs/require.js" data-main = "<?php echo $this->niveau; ?>assets/js/main.js" ></script>
</body>
</html>