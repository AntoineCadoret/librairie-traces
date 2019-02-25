<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title><?php echo gettext('Librairie Traces - Connexion'); ?></title>
    <link rel="stylesheet" href="<?php echo $this->niveau ?>/assets/css/styles.css">
    <link rel="icon" href="<?php echo $this->niveau?>assets/images/favicon.png" />
</head>
<body>
<a href="#" class="visuallyhidden focusable"><?php echo gettext('Aller au menu'); ?></a>
<a href="#contenu" class="visuallyhidden focusable"><?php echo gettext('Aller au contenu'); ?></a>
<?php echo $this->entete ?>
<main id="contenu" class="wrap formulaire">
    <howto-tabs2 aria-label="onglets">
        <!--Connexion-->
        <howto-tab role="heading" slot="tab" class="h1"><?php echo gettext('Connexion'); ?></howto-tab>
        <howto-panel role="region" slot="panel">
            <section id="connexion">
                <div class="autreOption">
                    <a href="#">Acheter sans créer un compte</a>
                    <p>OU</p>
                </div>
                <form action="<?php $this->niveau?>connexion.php">
                    <fieldset>
                        <p>
                            <label for="adressecourriel">Adresse courriel</label>
                            <input type="text" required aria-required="true" pattern="^[a-z0-9.-]{3,30}[@][a-z-]{2,15}[.][a-z]{2,8}[.]?[a-z]{0,8}$" id="adressecourrielConnexion" minlength="5" name="courriel">
                        </p>
                        <p class="erreur" aria-live="assertive" aria-atomic="true"></p>

                        <p>
                            <label for="motdepasse">Mot de passe</label>
                            <input type="password" required aria-required="true" pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,12}$" name="motPasse">
                        </p>
                        <p class="erreur" aria-live="assertive" aria-atomic="true"></p>
                        <p><input type="checkbox" name="afficherMdp">Afficher le mot de passe<br></p>


                        <span><a href="#">Mot de passe oublié?</a></span>
                        <input type="hidden" name="inscription" class="inscription" value="false">
                    </fieldset>
                    <div>
                        <button class="boutonPrimaire">Se connecter</button>
                    </div>
                </form>
                <span><p>Vous n'avez pas de compte? <a href="#">Créer un compte</a></p></span>
            </section>
        </howto-panel>
        <!--Inscription-->
        <howto-tab role="heading" slot="tab" class="h1"><?php echo gettext('Inscription'); ?></howto-tab>
        <howto-panel role="region" slot="panel">
            <section id="inscription">
                <div class="autreOption">
                    <a href="#">Acheter sans créer un compte</a>
                    <p>OU</p>
                </div>
                <form action="<?php $this->niveau ?>connexion.php">
                    <fieldset>
                        <p>
                            <label for="prenom">Prénom</label>
                            <input type="text" required aria-required="true" id="prenom" name="prenom"
                                   pattern="^[A-ZÀ-Ÿ]{1}[a-zà-ÿ]{1,30}[ '-]?[A-ZÀ-Ÿ]?[a-zà-ÿ]{0,25}$">
                        </p>
                        <p class="erreur" aria-live="assertive" aria-atomic="true"></p>
                        <p>
                            <label for="nom">Nom</label>
                            <input type="text" required aria-required="true" id="nom"
                                   pattern="^[A-ZÀ-Ÿ]{1}[a-zà-ÿ]{1,30}[ '-]?[A-ZÀ-Ÿ]?[a-zà-ÿ]{0,25}$" name="nom">
                        </p>
                        <p class="erreur" aria-live="assertive" aria-atomic="true"></p>
                        <p>
                            <label for="telephone"># de téléphone</label>
<!--                            <input type="text" required aria-required="true" name="telephone"-->
<!--                                   pattern="^[(][0-9]{3}[)] [0-9]{3}-[0-9]{4}$">-->
<!--                            <span class="legende">(xxx) xxx-xxxx</span>-->
                            <input type="text" required aria-required="true" name="telephone"
                                   pattern="^[0-9]{10}$">
                            <span class="legende">1234567890</span>
                        </p>
                        <p class="erreur" aria-live="assertive" aria-atomic="true"></p>

                        <p>
                            <label for="adressecourriel">Adresse courriel</label>
                            <input type="text" required aria-required="true"
                                   pattern="^[a-z0-9.-]{3,30}[@][a-z-]{2,15}[.][a-z]{2,8}[.]?[a-z]{0,8}$" id="adressecourrielInscription"
                                   minlength="2" name="courriel">
                        </p>
                        <p class="erreur" aria-live="assertive" aria-atomic="true"></p>

                        <p>
                            <label for="motDePasse">Mot de passe</label>
                            <input type="password" required aria-required="true" id="motDePasse"
                                   pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,12}$" name="motPasse">
                        <div class="legende">Doit contenir au moins une minuscule, une majuscule et un chiffre. Entre 6
                            et 12
                            caractères
                        </div>
                        </p>
                        <p class="erreur" aria-live="assertive" aria-atomic="true"></p>

                        <input type="hidden" name="inscription" class="inscription" value="true">
                    </fieldset>
                    <div>
                        <button type="submit" class="boutonPrimaire">Créer le compte</button>
                    </div>
                </form>
                <span>
                    <p>Vous avez déjà un compte? <a href="#">Se connecter</a></p>
                </span>
            </section>
        </howto-panel>
    </howto-tabs2>
</main>
<?php echo $this->pieddepage ?>


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




<script src="<?php echo $this->niveau; ?>node_modules/requirejs/require.js"
        data-main="<?php echo $this->niveau; ?>assets/js/main.js"></script>
<script>const strNiveau = "<?php echo $this->niveau;?>";</script>

</body>
</html>