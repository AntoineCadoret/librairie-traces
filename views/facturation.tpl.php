<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>
        Librairie Traces - <?php echo gettext('information de livraison'); ?>
    </title>
    <link rel="stylesheet" href="<?php echo $this->niveau . "/assets/css/styles-b.css"; ?>">
</head>
<body>
<a href="#" class="visuallyhidden focusable"><?php echo gettext('Aller au menu'); ?></a>
<a href="#contenu" class="visuallyhidden focusable"><?php echo gettext('Aller au contenu'); ?></a>
<?php echo $this->entete; ?>
<main class="wrap">
    <ol class="stepsBar">
        <li class="stepsBar__title is-completed"  id="step1title">
            <span><svg class="barreProg"><use xlink:href="#checkmark-symbol"></use></svg></span>Livraison</li>
        <li class="stepsBar__title is-completed"  id="step2title">
            <span><svg class="barreProg"><use xlink:href="#down-arrow"></use></svg></span>Facturation</li>
        <li class="stepsBar__title"  id="step3title">
            <span><svg class="barreProg"><use xlink:href="#right-arrow"></use></svg></span>Validation</li>
    </ol>
    <h1><?php echo gettext('Facturation'); ?></h1>
    <!-- FORMULAIRE À CRÉER-->
    <form class="formMultiSteps">
        <!-- Étape 2 ! -->
        <section aria-labelledby="step1title"
                 id="step-2"
                 tabindex="-1"
                 class="formMultiSteps__step">
            <section class="sectionOnglet">
                <!-- la section des 3 onglets -->
                <howto-tabs aria-label="onglets" class="ctnForm">
                    <howto-tab role="heading" slot="tab"><?php echo gettext('Mode de paiement'); ?></howto-tab>
                    <howto-panel role="region" slot="panel">
                        <ul>
                            <li class="btnRadio">
                                <input type="radio" data-groupe="typeCarte" name="modePaiement" id="masterCarte"
                                       value="masterCarte"
                                       required
                                       aria-required>
                                <label for="masterCarte">Master Card</label>
                            </li>
                            <li class="btnRadio">
                                <input type="radio" data-groupe="typeCarte" name="modePaiement" id="visa" value="visa">
                                <label for="visa">Visa</label>
                            </li>
                        </ul>
                        <p class="erreur" aria-live="assertive" aria-atomic="true"></p>
                    </howto-panel>

                    <howto-tab role="heading" slot="tab">Paypal</howto-tab>
                    <howto-panel role="region" slot="panel">
                        <a>Se connecter avec <span class="paypal">PayPal</span></a>
                    </howto-panel>
                </howto-tabs>
            </section>

            <div>
                <fieldset>
                    <div class="ctnForm">
                        <div>
                            <label for="numCarte"><?php echo gettext('Numéro de la carte: '); ?></label>
                            <input type="text" name="numCarte" id="numCarte" required aria-required
                                   pattern="^[0-9]{16}$">
                        </div>
                        <p class="erreur" aria-live="assertive" aria-atomic="true"></p>
                    </div>
                    <div class="ctnForm">
                        <div>
                            <label for="nomTitulaire"><?php echo gettext('Nom du titulaire de la carte: '); ?></label>
                            <input type="text" name="nomTitulaire" id="nomTitulaire" required aria-required
                                   pattern="^[a-zA-Z -]{2,55}$">
                        </div>
                        <p class="erreur" aria-live="assertive" aria-atomic="true"></p>
                    </div>
                    <div class="ctnForm">
                        <div>
                            <label for="dateExpiration"><?php echo gettext("Date d'expiration: "); ?></label>
                            <input type="text" name="dateExpiration" id="dateExpiration" required aria-required
                                   pattern="^[2]{1}[0-9]{3}-[0-1]{1}[0-9]{1}-[0-3]{1}[0-9]{1}$">
                        </div>
                        <p class="erreur" aria-live="assertive" aria-atomic="true"></p>
                    </div>
                    <div class="ctnForm">
                        <div>
                            <label for="numSecurite"><?php echo gettext("Numéro de sécurité: "); ?></label>
                            <input type="text" name="numSecurite" id="numSecurite" required aria-required
                                   pattern="^[0-9]{3}$">
                        </div>
                        <p class="erreur" aria-live="assertive" aria-atomic="true"></p>
                    </div>
                </fieldset>
            </div>

            <div>
                <h2><?php echo gettext("Adresse de facturation"); ?></h2>
                <fieldset class="fieldsetAjaxProvince">
                    <div class="ctnForm">
                        <div>
                            <label for="prenom">Prénom: </label>
                            <input type="text" name="prenom" id="prenom" required aria-required
                                   pattern="^[a-zA-Z\- ]+$"
                                   title="Utilisez des lettres, des traits d'unions ou des espaces pour composer votre prénom.(Les accent ne sont pas permit)">
                        </div>
                        <p class="erreur" aria-live="assertive" aria-atomic="true"></p>
                    </div>

                    <div class="ctnForm">
                        <div>
                            <label for="nom">Nom: </label>
                            <input type="text" name="nom" id="nom" required aria-required
                                   pattern="^[a-zA-Z\- ]+$"
                                   title="Utilisez des lettres, des traits d'unions ou des espaces pour composer votre nom.(Les accent ne sont pas permit)">
                        </div>
                        <p class="erreur" aria-live="assertive" aria-atomic="true"></p>
                    </div>

                    <div class="ctnForm">
                        <div>
                            <label for="adresse">Adresse: </label>
                            <input type="text" name="adresse" id="adresse" required aria-required
                                   pattern="^['0-9a-zA-Z\- ]+$">
                        </div>
                        <p class="erreur" aria-live="assertive" aria-atomic="true"></p>
                    </div>

                    <div class="ctnForm">
                        <div>
                            <label for="ville">Ville</label>
                            <input type="text" name="ville" id="ville" required aria-required>
                        </div>
                        <p class="erreur" aria-live="assertive" aria-atomic="true"></p>
                    </div>

                    <noscript class="noScript">
                        <div class="ctnForm">
                            <div>
                                <label for="province">Province</label>
                                <select name="province">
                                    <option>Sélectionner</option>
                                    <option value="AB">Alberta</option>
                                    <option value="BC">Colombie Britannique</option>
                                    <option value="MB">Manitoba</option>
                                    <option value="NB">New Brunswick</option>
                                    <option value="NL">Terre-Neuve-et-Labrador</option>
                                    <option value="NS">Nouvelle-Écosse</option>
                                    <option value="NT">Territoires du Nord-Ouest et Nunavut</option>
                                    <option value="ON">Ontario</option>
                                    <option value="PE">Île du Prince Édouard</option>
                                    <option value="QC">Québec</option>
                                    <option value="SK">Saskatchewan</option>
                                    <option value="YT">Yukon</option>
                                </select>
                            </div>
                            <p class="erreur" aria-live="assertive" aria-atomic="true"></p>
                        </div>
                    </noscript>
                    <div class="ctnForm">
                        <div>
                            <label for="codePostal">Code postal (X1X 1X1)</label>
                            <input type="text" name="codePostal" id="codePostal"
                                   maxlength="7"
                                   value=""
                                   required aria-required="true">&nbsp;
                            <img hidden id="ajaxOccupe" alt="En attente"
                                 src="<?php echo $this->niveau; ?>assets/images/retroaction.gif" width="16" height="16">
                        </div>
                        <p class="erreur" aria-live="assertive" aria-atomic="true"></p>
                    </div>
                </fieldset>
            </div>

            <div>
                <h2><?php echo gettext("Information de contact"); ?></h2>
                <fieldset>
                    <div class="ctnForm">
                        <div>
                            <label for="courriel">Courriel: </label>
                            <input type="email" name="courriel" id="courriel"
                                   value=""
                                   required aria-required="true">&nbsp;
                        </div>
                        <p class="erreur" aria-live="assertive" aria-atomic="true"></p>
                    </div>

                    <div class="ctnForm">
                        <div>
                            <label for="numTelephone">Numéro de téléphone: </label>
                            <input type="text" name="numTelephone" id="numTelephone"
                                   pattern="^[0-9]{10}$"
                                   value=""
                                   required aria-required="true">&nbsp;
                            <span>(000 000 0000)</span>
                        </div>
                        <p class="erreur" aria-live="assertive" aria-atomic="true"></p>
                    </div>
                </fieldset>
            </div>
            <button type="submit"
                    name="btn_enregistrer"><?php echo gettext('enregistrer les information'); ?></button>
        </section>
    </form>
</main>

<?php echo $this->pieddepage; ?>

<!--D'abord charger le polyfill avec un lien conforme à la doc: https://github.com/WebComponents/webcomponentsjs -->
<script src="https://unpkg.com/@webcomponents/webcomponentsjs@2.0.0/webcomponents-bundle.js"></script>

<!-- On charge le fichier principal (main ou app) qui importe la ou les classes et instancie l'app. -->
<script src="<?php echo $this->niveau; ?>node_modules/requirejs/require.js"
        data-main="<?php echo $this->niveau; ?>assets/js/main.js"></script>


<!--balise script cdn à jour été 2018-->
<script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous">
</script>
<!--balise script pour chargement local de la version installée avec Bower-->
<script>window.jQuery || document.write('<script src="<?php echo $this->niveau;?>node_modules/jquery/dist/jquery.min.js">\x3C/script>')</script>

<script>const strNiveau = "<?php echo $this->niveau;?>";</script>
</body>
</html>