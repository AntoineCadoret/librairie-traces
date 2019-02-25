<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>Librairie Traces - <?php echo gettext('Confirmation de la commmande'); ?></title>
    <link rel="stylesheet" href="<?php echo $this->niveau ?>assets/css/styles.css">
</head>
<body>
<a href="#contenu" class="visuallyhidden focusable"> <?php echo gettext('Aller au contenu') ?></a>
<a href="#menu" class="visuallyhidden focusable"> <?php echo gettext('Aller au menu') ?></a>

<?php echo $this->entete; ?>
<img src="<?php echo $this->niveau; ?>/assets/images/logo-traces.png" alt="Logo Traces" width="300" class="logoTracesImpression">
<div>
    <!---TODO ligne de progression-->
</div>
<div class="wrap" id="contenu">
    <div class="transaction">
        <h3>Nous avons bien reçu votre commande.</h3>
        <p>
            Elle vous sera expédiée le <?php echo $this->dateLivraison;?> selon les modalités que vous avez choisies.
            N’hésitez pas à consulter notre service à la clientèle pour plus d’informations relatives à votre commande
            ou votre compte. Votre numéro de confirmation est le: XXXXXXXXX.
            Vous recevrez une confirmation de votre commande par courriel d’ici quelques minutes.
        </p>
    </div>
    <h1><?php echo gettext('Confirmation de la commande'); ?></h1>
        <section id="resumeTransaction">
            <h3>Sommaire de votre commande</h3>
            <main class="wrap">
                <div>
                    <p>Livré à : <?php echo $this->arrTransaction['adresseLivraison']['prenom_adresse'] . ' ' . $this->arrTransaction['adresseLivraison']['nom_adresse']; ?></p>
                </div>
                <h3><?php echo gettext('Article(s) commandé(s)') . " (" . $this->nombreTotalArticle; ?>)</h3>
                <table class="tableauItem">
                    <thead class="text-danger">
                    <tr class="maj">
                        <th aria-label="information du livre"></th>
                        <th>Prix</th>
                        <th>Quantité</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (isset($this->tableauPanier)) { ?>
                        <?php foreach ($this->tableauPanier as $isbn => $arrInfoPanier) { ?>
                            <tr>
                                <td>
                                    <hr>
                                    <div class="imageLivre">
                                        <img src="https://via.placeholder.com/75x100">
                                    </div>
                                    <div class="infoLivre">
                                        <h3><?php echo $arrInfoPanier['titre_livre']; ?></h3>
                                        <?php foreach ($arrInfoPanier['auteurMultiple'] as $arrAuteurs) { ?>
                                            <h4><?php echo $arrAuteurs; ?></h4>
                                        <?php } ?>
                                    </div>
                                </td>
                                <td><?php echo $arrInfoPanier['prix'] . "$"; ?></td>
                                <td>
                                    <label for="quantiteLivre"><?php echo $arrInfoPanier['quantite']; ?>
                                    </label>
                                </td>
                                <td>
                                    <p hidden>Total: </p>
                                    <p><?php echo $this->objPanier->calculerSousTotalItem($isbn, $arrInfoPanier['quantite']) . "$"; ?></p>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                    </tbody>
                </table>
                <div>
                    <div>
                        <p>Sous-total(<?php echo $this->nombreTotalArticle; ?>):
                            <span>CAD <?php echo $this->sousTotal . "$"; ?></span></p>
                        <p>TPS 5%: <span>CAD <?php echo $this->TPS . "$"; ?></span></p>
                    </div>
                    <div>
                        <label for="typeLivraison">Livraison: <?php if ($this->typeLivraison == "standard") { echo "Standard";} elseif ($this->typeLivraison == "rapide") { echo "rapide"; }?></label>
                        <p>Prix livraison: <?php echo $this->fraisLivraison . "$"; ?></p>
                        <p>Date livraison estimée: <?php echo $this->dateLivraison; ?></p>
                    </div>
                    <div>
                        <p>TOTAL: <span>CAD <?php echo $this->coutTotal; ?>$</span></p>
                    </div>
                </div>
            </main>

                    <h2><?php echo gettext('Information de livraison:'); ?></h2>
            <h3><?php echo gettext('Adresse de livraison'); ?></h3>
            <p><?php echo $this->arrTransaction['adresseLivraison']['prenom_adresse'] . ' ' . $this->arrTransaction['adresseLivraison']['nom_adresse']; ?></p>
            <p><?php echo $this->arrTransaction['adresseLivraison']['adresse']; ?></p>
            <p><?php echo $this->arrTransaction['adresseLivraison']['ville']; ?></p>
            <p><?php echo $this->arrTransaction['adresseLivraison']['nom_province'] ?>, Canada</p>
            <p><?php echo $this->arrTransaction['adresseLivraison']['code_postal'] ?></p>


            <h3><?php echo gettext('Adresse de facturation'); ?></h3>
            <p><?php echo $this->arrTransaction['adresseFacturation']['prenom_adresse'] . ' ' . $this->arrTransaction['adresseFacturation']['nom_adresse']; ?></p>
            <p><?php echo $this->arrTransaction['adresseFacturation']['adresse']; ?></p>
            <p><?php echo $this->arrTransaction['adresseFacturation']['ville']; ?></p>
            <p><?php echo $this->arrTransaction['adresseFacturation']['nom_province'] ?>, Canada</p>
            <p><?php echo $this->arrTransaction['adresseFacturation']['code_postal'] ?></p>

<!--                    <h2>--><?php //echo gettext('Information paiement:'); ?><!--</h2>-->
            <h3><?php echo gettext('Mode de paiement: carte de crédit'); ?></h3>
            <p><?php echo $this->arrTransaction['mode_paiement']['nom_complet']; ?></p>
            <p>Image carte</p>
            <p><?php echo $this->arrTransaction['mode_paiement']['no_carte'] ?></p>
        </section>
<!--        <input type="hidden" name="destroy" value="true">-->
        <button id="boutonImpression" class="boutonPrimaire">Imprimer le reçu de votre commande</button>

    <a href="<?php echo $this->niveau ?>livres/index.php" class="btnLien" >Continuer à magasiner</a>
</div>
<?php echo $this->pieddepage; ?>
</body>
<script>
    //Impression
    document.getElementById('boutonImpression').addEventListener("click", window.print);
</script>
</html>