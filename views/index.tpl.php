<!DOCTYPE html>
<html lang="fr">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title><?php echo gettext('Librairie Traces - Accueil'); ?></title>
    <link rel="stylesheet" href="<?php echo $this->niveau ?>assets/css/styles.css">
    <link rel="icon" href="<?php echo $this->niveau?>assets/images/favicon.png" />
</head>
<body>
<a href="#contenu" class="visuallyhidden focusable"><?php echo gettext('Aller au contenu'); ?></a>
<?php echo $this->entete ?>
<main id="contenu">

    <h1 class="h1"><?php echo gettext('Librairie Traces'); ?></h1>


    <section id="coupCoeur" class="wrap coupCoeur">
        <!--        <h2>--><?php //echo gettext('Coups de coeur'); ?><!--</h2>-->
        <!--        --><?php //foreach ($this->coupCoeur as $arrCoupsCoeur) { ?>
        <!--            <div class="coupCoeur__contenu">-->
        <!--                <img-->
        <!--                        src='https://via.placeholder.com/450x450'>-->
        <!--                <div class="coupCoeur__contenu--texte">-->
        <!--                <h3>--><?php //echo $arrCoupsCoeur['titre_livre']; ?><!--</h3>-->
        <!--                <p>--><?php //echo $arrCoupsCoeur['prix']; ?><!--</p>-->
        <!--                <p>--><?php //echo $arrCoupsCoeur['description_livre']; ?><!--</p>-->
        <!--                    <button class='boutonPrimaire'>-->
        <?php //echo gettext('Ajouter au panier'); ?><!--</button>-->
        <!--                </div>-->
        <!---->
        <!--            </div>-->

        <!--        --><?php //} ?>
        <div class="wrap">
            <img src="<?php echo $this->niveau ?>/assets/images/coupCoeur5.png" alt="coupDeCoeur">
        </div>
    </section>


    <section id="nouveautes" class="wrap nouveautes">
        <h2><?php echo gettext('Nouveautés'); ?>
            <a href="<?php echo $this->niveau ?>livres/index.php?contexte=nouveautes" class="nouveautes__lien">
                <?php echo gettext('En afficher plus'); ?>
            </a>
        </h2>
        <div class="flexbox-1">
            <?php foreach ($this->nouveautes as $arrNouveautesChoisies) { ?>
                <div class="nouveautes__livre flexbox-2">
                    <div class="nouveautes__imgFond">
                        <a href="<?php echo $this->niveau . "livres/fiche.php?contexte=nouveautes&isbn=" . $arrNouveautesChoisies['isbn']; ?>"
                           class="flexbox-3">
                            <img class=""
                                 src="<?php if (file_exists($this->niveau . "assets/images/couvertures/L" . ISBNToEAN($arrNouveautesChoisies['isbn']) . "1.jpg")) {
                                     echo $this->niveau . "assets/images/couvertures/L" . ISBNToEAN($arrNouveautesChoisies['isbn']) . "1.jpg";
                                 } else {
                                     echo $this->niveau . "assets/images/couvertures/cover.png";
                                 } ?>" alt="Image du livre">
                        </a>
                    </div>

                    <h3 class="h4">
                        <a href="<?php echo $this->niveau . "livres/fiche.php?contexte=nouveautes&isbn=" . $arrNouveautesChoisies['isbn']; ?>">
                            <?php echo $arrNouveautesChoisies['titre_livre']; ?>
                        </a>
                    </h3>
                    <?php foreach ($arrNouveautesChoisies['auteurMultiple'] as $arrAuteur): ?>
                        <?php foreach ($arrAuteur['nom_auteur'] as $arrNomAuteur): ?>
                            <p>
                                <?php echo $arrNomAuteur['nom_auteur']; ?>
                            </p>
                        <?php endforeach ?>
                    <?php endforeach ?>
                    <p><?php echo $arrNouveautesChoisies['prix']; ?>$</p>
                    <button class="btnLien"><?php echo gettext('Ajouter au panier'); ?></button>
                </div>
            <?php } ?>
        </div>
    </section>


    <section id="actualites">
        <h2 class="wrap"><?php echo gettext('Actualités'); ?></h2>
        <div class="actualites">
            <div class="wrap">
                <?php $intPassage = 1;
                foreach ($this->actualites as $arrActualites): ?>
                    <div class="actualites__article flexbox-1">
                        <div class="actualites__article__contenu flexbox-3"
                             style="background-image: url('<?php echo $this->niveau ?>assets/images/actu<?php echo $intPassage ?>.jpg'); no-repeat; background-size: cover;">
                            <div class="filtre flexbox-2">
                            <span class="bloc_info">
                                <p class="date"><?php echo $arrActualites['date_actualite']; ?></p>
                                <h4 class="auteur"><?php echo $arrActualites['nom_auteur']; ?></h4>
                            </span>
                                <h3 class="actualites__article__titre "><?php echo $arrActualites['titre_actualite']; ?></h3>
                                <p><?php echo $arrActualites['texte_actualite']; ?></p>
                            </div>
                            <!-- liens redondants comme « Lire la suite », leur cible (le titre de-->
                            <!-- l’article) est précisée dans un span visuallyhidden ou dans le alt d’une img →-->
                        </div>
                        <a href="#" class="actualites__article__lien"><?php echo gettext('Lire la suite >'); ?></a>
                    </div>
                    <?php $intPassage++;
                endforeach; ?>
            </div>
        </div>
        <div class="boutonActu">
            <a class="boutonPrimaire" href="#"><?php echo gettext('Afficher plus d\'actualités'); ?></a>
        </div>
    </section>
</main>
<?php echo $this->pieddepage ?>
</body>
</html>