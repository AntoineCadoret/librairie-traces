<header class="entete">
    <a href="<?php echo $this->niveau; ?>index.php">
        <img src="<?php echo $this->niveau; ?>assets/images/logo-traces.png" alt="Logo de Traces" class="logo">
    </a>
    <nav class="menu__liste">
        <div class="menu__bloc">
            <ul class="navPrincipale">
                <li class="menu__listeItem"><a
                            href="<?php echo $this->niveau; ?>livres/index.php"><?php echo gettext('Livres'); ?></a>
                </li>
                <li class="menu__listeItem"><a href="#"><?php echo gettext('Meilleurs vendeurs'); ?></a></li>
                <li class="menu__listeItem"><a href="#"><?php echo gettext('Découvrir Traces'); ?></a></li>
                <li class="menu__listeItem"><a href="#"><?php echo gettext('Auteurs'); ?></a></li>
                <li class="menu__listeItem"><a href="#"><?php echo gettext('Nous joindre'); ?></a></li>
            </ul>
        </div>
        <div class="secondeNav">
            <div class="wrap">
                <ul>
                    <li class="liste">
                        <select name="rechercher" id="recherche">
                            <option value="sujet"><?php echo gettext('Sujet'); ?></option>
                            <option value="auteur"><?php echo gettext('Auteur'); ?></option>
                            <option value="titre"><?php echo gettext('Titre'); ?></option>
                            <option value="isbn"><?php echo gettext('ISBN'); ?></option>
                        </select>
                    </li>
                    <form method="get"
                          name="fRecherche"
                          id="fRecherche"
                          action="#">
                        <!--                    <div class="autocompletion">-->
                        <input type="text"
                               name="motsCles"
                               class="autocompletion__motsCles"
                               title="Entrer les premières lettres de la couleur recherchée"
                               autocomplete="off">
                        <!--                        <!-- avec JS et PHP on ajoute ici le div.autocompletion__data et les 'data' -->
                        <input type="submit" name="btnSubmitRecherche" id="btnSubmitRecherche" value="Rechercher">
<!--                        <svg class="icone recherche" ><use xlink:href="#search"></use></svg>-->
                        <!--                        <!-- avec JS, on ajoute ici au besoin l'indicateur de progrès (spinner) -->
                        <!--                    </div>-->
                    </form>
                    <li class="ctrlPanier">
                        <span class="ctrlPanier__titre">
                        <a class="lienPanier" href="<?php echo $this->niveau; ?>transaction/panier.php"
                           title="Lien vers la page panier!">
                        <svg class="icone"><use xlink:href="#shopping-cart"></use></svg></a>
                            </a>
                            <?php if ($this->nombreArticles > 0) { ?>
                                <span class="ctrlPanier__nombreItems"><?php echo $this->nombreArticles; ?></span>
                            <?php } ?>
                        </span>
                    </li>
                    <li>
                        <?php $clientConnecte = "non";
                        if ($clientConnecte === "connecte") { ?>
                            <a href="<?php session_destroy(); ?>">Se déconnecter</a>
                        <?php } else { ?>
                        <a href="<?php echo $this->niveau; ?>connexion.php">Se connecter</a><?php } ?>
                    </li>

                    <?php if (isset($this->langue) && $this->langue == "en") { ?>
                        <?php if ($_SERVER['QUERY_STRING'] != "") { ?>
                            <li><a href="<?php echo $_SERVER['REQUEST_URI'] ?>&lang=fr"
                                   class="lien__fondBlanc">FR</a></li>
                        <?php } else { ?>
                            <li><a href="<?php echo $_SERVER['REQUEST_URI'] ?>?lang=fr"
                                   class="lien__fondBlanc">FR</a></li>
                        <?php } ?>
                    <?php } else { ?>
                        <?php if ($_SERVER['QUERY_STRING'] != "") { ?>
                            <li><a href="<?php echo $_SERVER['REQUEST_URI'] ?>&lang=en"
                                   class="lien__fondBlanc">EN</a></li>
                        <?php } else { ?>
                            <li><a href="<?php echo $_SERVER['REQUEST_URI'] ?>?lang=en"
                                   class="lien__fondBlanc">EN</a></li>
                        <?php } ?>
                    <?php } ?>

                </ul>
                <div class="divRetroaction">
                    <?php echo $this->retroPanier; ?>
                    <?php echo $this->x; ?>
                </div>
            </div>
        </div>
    </nav>
</header>
