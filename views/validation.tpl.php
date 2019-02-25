<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>
        Librairie Traces - <?php echo gettext('Validation de commande'); ?>
    </title>
    <link rel="stylesheet" href="<?php echo $this->niveau . "/assets/css/styles-b.css"; ?>">
</head>
<body>
<a href="#" class="visuallyhidden focusable"><?php echo gettext('Aller au menu'); ?></a>
<a href="#contenu" class="visuallyhidden focusable"><?php echo gettext('Aller au contenu'); ?></a>
<?php echo $this->entete ?>
<main class="wrap">
    <ol class="stepsBar">
        <li class="stepsBar__title is-completed"  id="step1title">
            <span><svg class="barreProg"><use xlink:href="#checkmark-symbol"></use></svg></span>Livraison</li>
        <li class="stepsBar__title is-completed"  id="step2title">
            <span><svg class="barreProg"><use xlink:href="#down-arrow"></use></svg></span>Facturation</li>
        <li class="stepsBar__title"  id="step3title">
            <span><svg class="barreProg"><use xlink:href="#right-arrow"></use></svg></span>Validation</li>
    </ol>
    <h1><?php echo gettext('Validation de commande'); ?></h1>
    <!-- FORMULAIRE À CRÉER-->
    <form class="formMultiSteps">
        <!-- Étape 3 ! -->
        <section aria-labelledby="step1title"
                 id="step-3"
                 tabindex="-1"
                 class="formMultiSteps__step">
            <div>
                <p>Livraison à : <?php echo $this->arrTransaction['adresseLivraison']['prenom_adresse'].' '.$this->arrTransaction['adresseLivraison']['nom_adresse']; ?></p>
                <p>Date estimée de livraison : <?php echo $this->dateLivraison; ?></p>
            </div>
            <h2><?php echo gettext('Article commandé') . " (" . $this->nombreTotalArticle; ?>)</h2>


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
                                    <h2><?php echo $arrInfoPanier['titre_livre']; ?></h2>
                                    <?php foreach ($arrInfoPanier['auteurMultiple'] as $arrAuteurs) { ?>
                                        <h3><?php echo $arrAuteurs; ?></h3>
                                    <?php } ?>
                                    <button type="submit" name="btnRetirer" value="<?php echo $isbn; ?>">Retirer du
                                        panier
                                    </button>

                                </div>
                            </td>
                            <td><?php echo $arrInfoPanier['prix'] . "$"; ?></td>
                            <td>
                                <label hidden for="quantiteLivre">Quantité:</label>
                                <select name="<?php echo $isbn; ?>" id="quantiteLivre">
                                    <option value="0"
                                        <?php if ($arrInfoPanier['quantite'] == 0) {
                                            echo 'selected';
                                        } ?>>0
                                    </option>
                                    <option
                                            value="1" <?php if ($arrInfoPanier['quantite'] == 1) {
                                        echo 'selected';
                                    } ?>>1
                                    </option>
                                    <option
                                            value="2" <?php if ($arrInfoPanier['quantite'] == 2) {
                                        echo 'selected';
                                    } ?>>2
                                    </option>
                                    <option value="3" <?php if ($arrInfoPanier['quantite'] == 3) {
                                        echo 'selected';
                                    } ?>>3
                                    </option>
                                    <option value="4" <?php if ($arrInfoPanier['quantite'] == 4) {
                                        echo 'selected';
                                    } ?>>4
                                    </option>
                                    <option value="5" <?php if ($arrInfoPanier['quantite'] == 5) {
                                        echo 'selected';
                                    } ?>>5
                                    </option>
                                    <option value="6" <?php if ($arrInfoPanier['quantite'] == 6) {
                                        echo 'selected';
                                    } ?>>6
                                    </option>
                                    <option value="7" <?php if ($arrInfoPanier['quantite'] == 7) {
                                        echo 'selected';
                                    } ?>>7
                                    </option>
                                    <option value="8" <?php if ($arrInfoPanier['quantite'] == 8) {
                                        echo 'selected';
                                    } ?>>8
                                    </option>
                                    <option value="9" <?php if ($arrInfoPanier['quantite'] == 9) {
                                        echo 'selected';
                                    } ?>>9
                                    </option>
                                    <option value="10" <?php if ($arrInfoPanier['quantite'] == 10) {
                                        echo 'selected';
                                    } ?>>10
                                    </option>
                                    <option value="11" <?php if ($arrInfoPanier['quantite'] == 11) {
                                        echo 'selected';
                                    } ?>>11
                                    </option>
                                    <option value="12" <?php if ($arrInfoPanier['quantite'] == 12) {
                                        echo 'selected';
                                    } ?>>12
                                    </option>
                                </select>
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
                    <label for="typeLivraison">Livraison:</label>
                    <select name="typeLivraison" id="typeLivraison">

                        <option value="standard" <?php if ($this->typeLivraison == "standard") {
                            echo 'selected';
                        } ?>>standard
                        </option>

                        <option value="rapide" <?php if ($this->typeLivraison == "rapide") {
                            echo 'selected';
                        } ?>>rapide
                        </option>
                    </select>
                    <p>Prix livraison: <?php echo $this->fraisLivraison . "$"; ?></p>
                    <p>Date livraison estimée: <?php echo $this->dateLivraison; ?></p>
                </div>
                <div>
                    <p>TOTAL: <span>CAD <?php echo $this->coutTotal; ?>$</span></p>

                    <button type="submit" name="btnRecalculer" class="btnLien">Recalculer</button>
                </div>
            </div>

            <div>
                <h2><?php echo gettext('Information paiement:'); ?></h2>
                <div>
                    <h3><?php echo gettext('Mode de paiement: carte de crédit'); ?></h3>
                    <p><?php echo $this->arrTransaction['mode_paiement']['nom_complet'];?></p>
                    <div>
                        <p>Image carte</p>
                        <p><?php echo $this->arrTransaction['mode_paiement']['no_carte']?></p>
                    </div>
                </div>
                <div>
                    <h3><?php echo gettext('Adresse de Facturation'); ?></h3>
                    <p><?php echo $this->arrTransaction['adresseFacturation']['prenom_adresse'].' '.$this->arrTransaction['adresseFacturation']['nom_adresse'];?></p>
                    <ul>
                        <li><?php echo $this->arrTransaction['adresseFacturation']['adresse'];?></li>
                        <li><?php echo $this->arrTransaction['adresseFacturation']['ville'];?></li>
                        <li><?php echo $this->arrTransaction['adresseFacturation']['nom_province']?>, Canada</li>
                        <li><?php echo $this->arrTransaction['adresseFacturation']['code_postal']?></li>
                    </ul>
                    <a href="facturation.php">modifier</a>
                </div>
                <div>
                    <h3><?php echo gettext('Informations'); ?></h3>
                    <p><?php echo $this->arrTransaction['clients']['courriel_client']?></p>
                    <p>Téléphone: <?php echo $this->arrTransaction['clients']['telephone_client']?></p>
                    <a href="facturation.php">modifier</a>
                </div>
            </div>
            <div>
                <h2><?php echo gettext('Information de livraison:'); ?></h2>
                <div>
                    <h3><?php echo gettext('Adresse de livraison'); ?></h3>
                    <p><?php echo $this->arrTransaction['adresseLivraison']['prenom_adresse'].' '.$this->arrTransaction['adresseLivraison']['nom_adresse'];?></p>
                    <ul>
                        <li><?php echo $this->arrTransaction['adresseLivraison']['adresse'];?></li>
                        <li><?php echo $this->arrTransaction['adresseLivraison']['ville'];?></li>
                        <li><?php echo $this->arrTransaction['adresseLivraison']['nom_province']?>, Canada</li>
                        <li><?php echo $this->arrTransaction['adresseLivraison']['code_postal']?></li>
                    </ul>
                    <a href="livraison.php">modifier</a>
                </div>
            </div>

            <p>
                <?php if ($this->nombreTotalArticle > 0) { ?>
                    <a href= <?php echo $this->niveau . "transaction/confirmation.php"; ?>>PASSER LA COMMANDE</a>
                <?php } ?>
            </p>
            <p>
                <a href=<?php echo $this->niveau . "livres" .">". gettext("Annuler la commande"); ?></a>
            </p>
        </section>
    </form>
</main>

<?php include($this->niveau . "views/partials/pieddepage.tpl.php") ?>
</body>
</html>