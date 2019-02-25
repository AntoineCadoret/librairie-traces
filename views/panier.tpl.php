<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>Librairie Traces - Panier</title>
    <link rel="stylesheet" href="<?php echo $this->niveau . "/assets/css/styles-c.css"; ?>">
</head>
<body>
<a href="#contenu" class="visuallyhidden focusable">Aller au contenu</a>
<?php include($this->niveau . "views/partials/entete.tpl.php"); ?>
<main class="wrap pagePanier">
    <form>
        <div>
            <h1>Mon panier d'achats</h1>
            <div>
                <div class="estimationDuHaut">
                    <?php if ($this->nombreTotalArticle > 0) { ?>
                        <p><?php echo $this->nombreTotalArticle; ?> article(s) dans votre panier</p>
                        <p>TOTAL ESTIMÉ : CAD <?php echo $this->sousTotal . "$"; ?></p>
                    <?php } else { ?>
                        <p>Votre panier est vide !</p>
                    <?php } ?>
                </div>


                <table class="tableauItems">
                    <thead class="text-danger">
                    <tr>
                        <th id="vign"></th>
                        <th id="desc" aria-label="information du livre"></th>
                        <th id="prix">Prix</th>
                        <th id="qte">Quantité</th>
                        <th id="sstotal">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (isset($this->tableauPanier)) { ?>
                        <?php foreach ($this->tableauPanier as $isbn => $arrInfoPanier) { ?>
                            <tr>
                                <td data-th="Vignette">
                                    <img
                                            src="<?php if (file_exists($this->niveau . "assets/images/couvertures/L" . ISBNToEAN($isbn) . "1.jpg")) {
                                                echo $this->niveau . "assets/images/couvertures/L" . ISBNToEAN($isbn) . "1.jpg" . '"';
                                            } else {
                                                echo $this->niveau . "assets/images/couvertures/cover.png" . '"' . 'class="livreSansImage"';
                                            } ?> alt=" Image du livre">

                                </td>
                                <td data-th="Description">
                                    <h2><?php echo $arrInfoPanier['titre_livre']; ?></h2>
                                    <?php foreach ($arrInfoPanier['auteurMultiple'] as $arrAuteurs) { ?>
                                        <h3><?php echo $arrAuteurs; ?></h3>
                                    <?php } ?>
                                    <p class="panier__actions">
                                        <button class="btnLien" type="submit" name="btnRetirer"
                                                value="<?php echo $isbn; ?>">Retirer du panier
                                        </button>
                                    </p>

                                </td>
                                <td data-th="Prix"><?php echo $arrInfoPanier['prix'] . "$"; ?></td>
                                <td data-th="Quantité">
                                    <label hidden for="quantiteLivre">Quantité:</label>
                                    <select aria-labelledby="qte" name="<?php echo $isbn; ?>" id="quantiteLivre">
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
                                <td data-th="Total">
                                    <?php echo $this->objPanier->calculerSousTotalItem($isbn, $arrInfoPanier['quantite']) . "$"; ?>
                                    <p class="panier__actions">
                                        <button class="btnLien" type="submit" name="btnRetirer"
                                                value="<?php echo $isbn; ?>">Retirer du panier
                                        </button>
                                    </p>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                    </tbody>
                </table>


                <div class="sousTotal">
                    <div>
                        <p><span class="gras">Sout-total (<?php echo $this->nombreTotalArticle; ?>): </span>
                            <span>CAD <?php echo $this->sousTotal . "$"; ?></span></p>
                        <p><span class="gras">TPS 5%: </span><span>CAD <?php echo $this->TPS . "$"; ?></span></p>
                    </div>
                    <div>
                        <label class="gras" for="typeLivraison">Livraison:</label>
                        <select name="typeLivraison" id="typeLivraison" class="selectLivraison">

                            <option value="standard" <?php if ($this->typeLivraison == "rapide") {
                                echo 'selected';
                            } ?>>standard
                            </option>

                            <option value="rapide" <?php if ($this->typeLivraison == "rapide") {
                                echo 'selected';
                            } ?>>rapide
                            </option>
                        </select>
                        <p><span class="gras">Prix livraison: </span><?php echo $this->fraisLivraison . "$"; ?></p>
                        <p><span class="gras">Date livraison estimée: </span><?php echo $this->dateLivraison; ?></p>
                    </div>
                </div>

                <div class="total">
                    <p class="coutTotal">TOTAL: <span>CAD <?php echo $this->coutTotal; ?>$</span></p>

                    <button class="btnRecalculer" type="submit" name="btnRecalculer">Recalculer</button>
                    <div class="divBtnBas">
                        <p>
                            <a class="btnLien" href= <?php echo $this->niveau . "livres"; ?>>Continuer à magasiner</a>
                        </p>
                        <p>
                            <?php if ($this->nombreTotalArticle > 0) { ?>
                                <a class="btnLien" href= <?php echo $this->niveau . "connexion.php"; ?>>PASSER LA
                                    COMMANDE</a>
                            <?php } ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>

</main>

<hr>
<?php include($this->niveau . "views/partials/pieddepage.tpl.php") ?>
</body>
</html>