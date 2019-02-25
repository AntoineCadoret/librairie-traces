<footer class="footer">
    <div class="wrap">
        <p>Achat sécurisé (avec logo)</p>
        <div class="footer__contenu">
            <div class="footer__contenu__contact">
                <h3>Nous joindre</h3>
                <ul>
                    <li>Trouver un magasin</li>
                    <li>1-800-999-8787</li>
                </ul>
            </div>
            <div>
                <ul class="mentionsLegales">
                    <li><a href="<?php echo $this->niveau; ?>#">Modes de livraison</a></li>
                    <li><a href="<?php echo $this->niveau; ?>#">Politiques de retour</a></li>
                    <li><a href="<?php echo $this->niveau; ?>#">Conditions d'utilisation</a></li>
                    <li><a href="<?php echo $this->niveau; ?>#">Politique de confidentialité</a></li>
                </ul>
            </div>
        </div>
        <p class="credit">©2018 - Tous droits réservés  - Librairie Traces</p>
    </div>
</footer>
<?php echo file_get_contents($this->niveau . "assets/images/icones.svg"); ?>
<scripts src="<?php echo $this->niveau;?>/assets/js/Autocompletion"></scripts>