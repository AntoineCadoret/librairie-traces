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
            <span><svg class="barreProg"><use xlink:href="#down-arrow"></use></svg></span>Livraison</li>
        <li class="stepsBar__title is-completed"  id="step2title">
            <span><svg class="barreProg"><use xlink:href="#right-arrow"></use></svg></span>Facturation</li>
        <li class="stepsBar__title"  id="step3title">
            <span><svg class="barreProg"><use xlink:href="#right-arrow"></use></svg></span>Validation</li>
    </ol>

    <h1><?php echo gettext('Livraison'); ?></h1>
    <!-- FORMULAIRE À CRÉER-->
    <form class="formMultiSteps">
        <!-- Étape 1 ! -->
        <section aria-labelledby="step1title"
                 id="step-1"
                 tabindex="-1"
                 class="formMultiSteps__step">

            <fieldset class="fieldsetAjaxProvince">
                <h2><?php echo gettext('Adresse de livraison: ') ?></h2>

                <p>
                    <label for="prenom"><?php echo gettext('Prénom: '); ?></label>
                    <input type="text" name="prenom" id="prenom" required aria-required
                           pattern="^[a-zA-Z\- ]+$"
                           title="Utilisez des lettres, des traits d'unions ou des espaces pour composer votre prénom.(Les accents ne sont pas permis)">
                </p
                <p>
                    <label for="nom"><?php echo gettext('Nom: ') ?></label>
                    <input type="text" name="nom" id="nom" required aria-required
                           pattern="^[a-zA-Z\- ]+$"
                           title="Utilisez des lettres, des traits d'unions ou des espaces pour composer votre nom.(Les accents ne sont pas permis)">
                </p>
                <p>
                    <label for="adresse"><?php echo gettext('Adresse: ') ?></label>
                    <input type="text" name="adresse" id="adresse" required aria-required
                           pattern="^['0-9a-zA-Z\- ]+$">
                </p>
                <p>
                    <label for="ville"><?php echo gettext('Ville: ') ?></label>
                    <input type="text" name="ville" id="ville" required aria-required>
                </p>
                <noscript class="noScript">
                    <p>
                        <label for="province">Province</label>
                        <select name="province" id="province">
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
                    </p>
                </noscript>
                <p>
                    <label for="codePostal"><?php echo gettext('Code postal'); ?> (X1X 1X1)</label>
                    <input type="text" name="codePostal" id="codePostal"
                           maxlength="7"
                           value=""
                           required aria-required="true">&nbsp;
                    <img hidden id="ajaxOccupe" alt="En attente"
                         src="<?php echo $this->niveau; ?>assets/images/retroaction.gif" width="16" height="16">
                </p>
            </fieldset>
            <div>
                <p>
                    <input type="checkbox" name="adresseParDefaut" id="accepterCondition" checked>
                    <label class="labelCheckbox"
                           for="adresseParDefaut"><?php echo gettext('Adresse de livraison par défaut'); ?></label>
                </p>
                <p>
                    <input type="checkbox" name="adresseFacturation" checked>
                    <label for="adresseFacturation">Utiliser comme adresse de facturation</label>
                </p>
                <button type="submit" name="btn_enregistrer"
                        class="formMultiSteps__btn"><?php echo gettext('enregistrer les informations'); ?></button>
            </div>
        </section>
    </form>
</main>
<?php echo $this->pieddepage; ?>

<!-- CDN v2018 -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>

<!-- ALT au CDN: chargement local de la version installée avec Bower -->
<script>window.jQuery || document.write('<script src="node_modules/jquery/dist/jquery.min.js">\x3C/script>')</script>

<!-- On charge le fichier principal (main ou app) qui importe la ou les classes et instancie l'app. -->
<script src="<?php echo $this->niveau; ?>node_modules/requirejs/require.js"
        data-main="<?php echo $this->niveau; ?>assets/js/main.js"></script>
<script>const strNiveau = "<?php echo $this->niveau;?>";</script>

</body>
</html>