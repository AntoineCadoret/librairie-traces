<footer class="footer">
    <div class="wrap">
        <div class="footer__contenu">
            <div class="footer__contenu__rappel">
                <ul class="menu__liste">
                    <li class="menu__listeItem">
                        <a href="<?php echo $this->niveau; ?>index.php" class="menu__lien link"><?php echo gettext('Accueil') ?></a>
                    </li>
                    <li class="menu__listeItem">
                        <a href="<?php echo $this->niveau; ?>livres/index.php" class="menu__lien link"><?php echo gettext("Livres") ?></a>
                    </li>
                    <li class="menu__listeItem">
                        <a href="#" class="menu__lien link"><?php echo gettext('Meilleurs vendeurs') ?></a>
                    </li>
                    <li class="menu__listeItem">
                        <a href="#" class="menu__lien link"><?php echo gettext("Découvrir Traces") ?></a>
                    </li>
                    <li class="menu__listeItem">
                        <a href="#" class="menu__lien link"><?php echo gettext("Auteurs") ?></a>
                    </li>
                    <li class="menu__listeItem">
                        <a href="#" class="menu__lien link"><?php echo gettext("Nous joindre")?></a>
                    </li>
                </ul>
            </div>
            <div class="footer__contenu__carte">
                <img src="<?php echo $this->niveau?>assets/images/carte.png" alt="Carte où nous sommes" width="300">
            </div>
            <div class="footer__contenu__contact">
                <h3><?php echo gettext("Nous joindre")?></h3>
                <ul>
                    <li><?php echo gettext("Trouver un magasin")?></li>
                    <li>1-800-999-8787</li>
                </ul>
            </div>
            <div class="footer__contenu__reseauxsociaux">
                <h3>Suivez-nous!</h3>
                <ul>
                    <li><a href="<?php echo $this->niveau; ?>#"><svg class="icone"><use xlink:href="#facebook-logo-button"></use></svg></a></li>
                    <li><a href="<?php echo $this->niveau; ?>#"><svg class="icone"><use xlink:href="#twitter-logo-button"></use></svg></a></li>
                    <li><a href="<?php echo $this->niveau; ?>#"><svg class="icone"><use xlink:href="#instagram-logo"></use></svg></a></li>
                </ul>
            </div>
        </div>
        <div>
            <ul class="mentionsLegales">
                <li><a href="<?php echo $this->niveau; ?>#"><?php echo gettext("Conditions d'utilisation") ;?></a></li>
                <li><a href="<?php echo $this->niveau; ?>#"><?php echo gettext("Politique de confidentialité") ;?></a></li>
            </ul>
        </div>
        <p class="credit">©2018 - Tous droits réservés  - Librairie Traces</p>
    </div>
</footer>
<?php echo file_get_contents($this->niveau . "assets/images/icones.svg"); ?>
<scripts src="<?php echo $this->niveau;?>/assets/js/Autocompletion"></scripts>