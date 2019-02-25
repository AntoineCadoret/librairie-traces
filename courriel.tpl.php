<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Confirmation d'achat</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta charset="UTF-8">
    <meta content="width=device-width">
    <style type="text/css">
        /* Fonts and Content */
        body, td {
            font-family: 'Helvetica Neue', Arial, Helvetica, Geneva, sans-serif;
            font-size: 14px;
        }

        body {
            background-color: #851139;
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: none;
            -ms-text-size-adjust: none;
        }

        h2 {
            padding-top: 12px; /* ne fonctionnera pas sous Outlook 2007+ */
            color: #0E7693;
            font-size: 22px;
        }

        @media only screen and (max-width: 480px) {

            table[class=w275], td[class=w275], img[class=w275] {
                width: 135px !important;
            }

            table[class=w30], td[class=w30], img[class=w30] {
                width: 10px !important;
            }

            table[class=w580], td[class=w580], img[class=w580] {
                width: 280px !important;
            }

            table[class=w640], td[class=w640], img[class=w640] {
                width: 300px !important;
            }

            img {
                height: auto;
            }

            /*illisible, on passe donc sur 3 lignes */
            table[class=w180], td[class=w180], img[class=w180] {
                width: 280px !important;
                display: block;
            }

            td[class=w20] {
                display: none;
            }
        }
    </style>
</head>
<body style="margin:0px; padding:0px; -webkit-text-size-adjust:none;">
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:rgb(42, 55, 78)">
    <tbody>
    <tr>
        <td align="center" bgcolor="#851139">
            <table cellpadding="0" cellspacing="0" border="0">
                <tbody>
                <tr>
                    <td class="w640" width="640" height="10"></td>
                </tr>

                <tr>
                    <td align="center" class="w640" width="640" height="20"><a style="color:#ffffff; font-size:12px;"
                                                                               href="#"><span
                                    style="color:#ffffff; font-size:12px;">Voir ce courriel dans votre navigateur</span></a>
                    </td>
                </tr>
                <tr>
                    <td class="w640" width="640" height="10"></td>
                </tr>
                <!-- entete -->
                <tr class="pagetoplogo">
                    <td class="w640" width="640">
                        <table class="w640" width="640" cellpadding="0" cellspacing="0" border="0" bgcolor="#F2F0F0">
                            <tbody>
                            <tr>
                                <td class="w30" width="30"></td>
                                <td class="w580" width="580" valign="middle" align="left">
                                    <div class="pagetoplogo-content">
                                        <img class="w580"
                                             style="text-decoration: none; display: block; color:#476688; font-size:30px;"
                                             src="<?php echo $this->niveau ?>assets/images/logo-traces.png"
                                             alt="Mon Logo" width="300" height="108"/>
                                    </div>
                                </td>
                                <td class="w30" width="30"></td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <!-- separateur horizontal -->
                <tr>
                    <td class="w640" width="640" height="1" bgcolor="#d7d6d6"></td>
                </tr>
                <!-- contenu -->
                <tr class="content">
                    <td class="w640" class="w640" width="640" bgcolor="#ffffff">
                        <table class="w640" width="640" cellpadding="0" cellspacing="0" border="0">
                            <tbody>
                            <tr>
                                <td class="w30" width="30"></td>
                                <td class="w580" width="580">
                                    <!-- une zone de contenu -->
                                    <table class="w580" width="580" cellpadding="0" cellspacing="0" border="0">
                                        <tbody>
                                        <tr>
                                            <td class="w580" width="580">
                                                <h2 style="color:#851139; font-size:22px; padding-top:12px; text-align: center">
                                                    Confirmation de votre transaction récente chez votre libraire
                                                    Traces</h2>

                                                <div align="left" class="article-content">
                                                    <p>Nous vous remercions de magasiner sur notre site <a href="#"
                                                                                                           style="color: #851139">www.librairie-traces.com</a>
                                                    </p>
                                                    <p>Vous trouverez ci-dessous les détails de votre commande réalisée
                                                        le <?php echo date('d F Y') ?>.</p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="w580" width="580" height="1" bgcolor="#c7c5c5"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <!-- fin zone -->
                                    <!-- une autre zone de contenu -->
                                    <table class="w580" width="580" cellspacing="0" cellpadding="0" border="0">
                                        <tbody>
                                        <tr>
                                            <td colspan="3">
                                                <h2 style="color:#851139; font-size:22px; padding-top:12px;">
                                                    Voici votre commande #00000053423 :</h2>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="w275" width="275" valign="top">
                                                <div align="left" class="article-content">
                                                    <h3><?php echo gettext('Article(s) commandé(s)') . " (" . $this->nombreTotalArticle; ?>
                                                        )</h3>
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
                                        </div>
                                        </td>
                                        <td class="w30" width="30" class="w30"></td>
                                        <td class="w275" width="275" valign="top">
                                            <div align="left" class="article-content">
                                                <p>Sous-total(<?php echo $this->nombreTotalArticle; ?>):</p>
                                                <p>CAD <?php echo $this->sousTotal . "$"; ?></p>
                                                <p>TPS 5%: CAD <?php echo $this->TPS . "$"; ?></p>
                                                <p>Prix livraison: <?php echo $this->fraisLivraison . "$"; ?></p>
                                                <p>TOTAL: <span>CAD <?php echo $this->coutTotal; ?>$</span></p>
                                            </div>
                                        </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="w580" height="1" bgcolor="#c7c5c5"></td>
                                        </tr>

                                        </tbody>
                                    </table>

                                    <table class="w580" width="580" cellpadding="0" cellspacing="0" border="0">
                                        <tbody>
                                        <tr>
                                            <td colspan="5">
                                                <h2 style="color:#851139; font-size:22px; padding-top:12px;">
                                                    Informations </h2>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="w180" width="180" valign="top">
                                                <h4>Adresse de livraison</h4>
                                                <div align="left" class="article-content">
                                                    <p><?php echo $this->arrTransaction['adresseLivraison']['prenom_adresse'] . ' ' . $this->arrTransaction['adresseLivraison']['nom_adresse']; ?></p>
                                                    <p><?php echo $this->arrTransaction['adresseLivraison']['adresse']; ?></p>
                                                    <p><?php echo $this->arrTransaction['adresseLivraison']['ville']; ?></p>
                                                    <p><?php echo $this->arrTransaction['adresseLivraison']['nom_province'] ?>
                                                        , Canada</p>
                                                    <p><?php echo $this->arrTransaction['adresseLivraison']['code_postal'] ?></p>
                                                </div>
                                            </td>
                                            <td class="w20" width="20"></td>
                                            <td class="w180" width="180" valign="top">
                                                <h4>Adresse de facturation</h4>
                                                <div align="left" class="article-content">
                                                    <p><?php echo $this->arrTransaction['adresseFacturation']['prenom_adresse'] . ' ' . $this->arrTransaction['adresseFacturation']['nom_adresse']; ?></p>
                                                    <p><?php echo $this->arrTransaction['adresseFacturation']['adresse']; ?></p>
                                                    <p><?php echo $this->arrTransaction['adresseFacturation']['ville']; ?></p>
                                                    <p><?php echo $this->arrTransaction['adresseFacturation']['nom_province'] ?>
                                                        , Canada</p>
                                                    <p><?php echo $this->arrTransaction['adresseFacturation']['code_postal'] ?></p>
                                                </div>
                                            </td>

                                            <td class="w20" width="20"></td>
                                            <td class="w180" width="180" valign="top">
                                                <h4>Mode de paiement</h4>
                                                <div align="left" class="article-content">
                                                    <p><?php echo $this->arrTransaction['mode_paiement']['no_carte'] ?></p>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="5" class="w580" width="580" height="1" bgcolor="#c7c5c5"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table class="w580" width="580" cellpadding="0" cellspacing="0" border="0">
                                        <tbody>
                                        <tr>
                                            <td class="w580" width="580">
                                                <div align="center" class="article-content">
                                                    <p>Équipe du service des ventes</p>
                                                    <p>servicedesventes@librairie-traces.com</p>
                                                    <p>Librairie Traces</p>
                                                    <p>49 des Jardins</p>
                                                    <p>Québec, QC</p>
                                                    <p>Canada, G1R 4L6</p>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td class="w30" class="w30" width="30"></td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>

                <!--  separateur horizontal de 15px de haut -->
                <tr>
                    <td class="w640" width="640" height="15" bgcolor="#ffffff"></td>
                </tr>

                <!-- pied de page -->
                <tr class="pagebottom">
                    <td class="w640" width="640">
                        <table class="w640" width="640" cellpadding="0" cellspacing="0" border="0" bgcolor="#c7c7c7">
                            <tbody>
                            <tr>
                                <td colspan="5" height="10"></td>
                            </tr>
                            <tr>
                                <td class="w30" width="30"></td>
                                <td class="w580" width="580" valign="top">
                                    <p align="center" class="pagebottom-content-left">
                                        <span style="color:#255D5C;">Se désabonner</span>
                                    </p>
                                </td>

                                <td class="w30" width="30"></td>
                            </tr>
                            <tr>
                                <td colspan="5" height="10"></td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="w640" width="640" height="60"></td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center" bgcolor="#2A374E">
            <table cellpadding="0" cellspacing="0" border="0">
                <tbody>
                <!-- contenu -->
                <tr class="content">
                    <td class="w640" class="w640" width="640" bgcolor="#ffffff">
                        <table class="w640" width="640" cellpadding="0" cellspacing="0" border="0">
                            <tbody>
                            <tr>
                                <td class="w30" width="30"></td>
                                <td class="w580" width="580">
                                    <!-- une zone de contenu -->

                                    <!-- fin zone -->

                                    <!-- une autre zone de contenu -->
                                </td>
                                <td class="w30" class="w30" width="30"></td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>

        </td>
    </tr>
    </tbody>
</table>
</body>
</html>