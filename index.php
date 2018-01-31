<?php

require_once 'src/autoload.php';

$security = new \Model\Security();
if ($security->isAuthenticated()) {
    header('Location: /2018/virtualdeck/auth/home.php');
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Virtual Deck</title>
    <link rel="stylesheet" href="/2018/virtualdeck/stylesheets/unauth.css"/>
    <link rel="stylesheet" href="/2018/virtualdeck/stylesheets/font-awesome.css">
    <link rel="icon" type="image/x-icon" href="/2018/virtualdeck/images/favicon.ico" />
</head>

<body>
<div id="page" class="page">
    <div id="logo" class="icon"></div>
    <div id="corpse">
        <div id="text">
            <div class="text">
                <span id="title">La</span> plateforme
            </div>
            <div class="text"> des jeux en Réalité Augmentée</div>
            <div id="videos">
                <video id="game1" class="video"><source src="/2018/virtualdeck/videos/Solitaire.mp4" type="video/mp4"></video>
                <video id="game3" class="hidden video"><source src="/2018/virtualdeck/videos/SeemsCity.mp4" type="video/mp4"></video>
                <video id="game4" class="hidden video"><source src="/2018/virtualdeck/videos/Strategy2.mp4" type="video/mp4"></video>
            </div>
        </div>
        <div id="connect" class="button">Se connecter</div>
        <div id="login_form" class="hidden">
            <div><input id="email" type="email" class="field" placeholder="Email"/></div>
            <div><input id="password" type="password" class="field" placeholder="Mot de passe"/></div>
            <div id="log_in">
                <input type="text" disabled class="field button" value="Connexion"/>
            </div>
        </div>
        <div id="error" class="button hidden">Erreur</div>
    </div>
    <div id="controls" class="fa">
        <div id="backward" class="button fa">&#xf048;</div>
        <div id="play" class="button fa">&#xf04b;</div>
        <div id="pause" class="button fa">&#xf04c;</div>
        <div id="forward" class="button fa">&#xf051;</div>
    </div>
</div>


<div id="sign_form" class="page">
    <div id="sign_normal">
        <div class="sign_label">Informations de compte</div>
        <div><label for="sign_username">Pseudonyme</label><input id="sign_username" type="text" class="field"/></div>
        <div><label for="sign_email">Email</label><input id="sign_email" type="email" class="field"/></div>
        <div><label for="sign_password">Mot de passe</label><input id="sign_password" type="password" class="field"/></div>
        <div><label for="sign_password2">Confirmer le mot de passe</label><input id="sign_password2" type="password" class="field"/></div>
    </div>
    <div id="sign_billing">
        <div class="sign_label">Informations de facturation</div>
        <div><label for="sign_firstname">Prénom</label><input id="sign_firstname" type="text" class="field"/></div>
        <div><label for="sign_lastname">Nom</label><input id="sign_lastname" type="text" class="field"/></div>
        <div><label for="sign_address">Adresse</label><input id="sign_address" type="text" class="field"/></div>
        <div><label for="sign_city">Ville</label><input id="sign_city" type="text" class="field"/></div>
        <div><label for="sign_postal">Code postal</label><input id="sign_postal" type="text" class="field"/></div>
        <div><label for="sign_phone">Téléphone</label><input id="sign_phone" type="text" class="field"/></div>
    </div>
    <div id="sign">
        <input type="text" disabled class="field button" value="S'inscrire"/>
    </div>
</div>
</body>

<footer>
    <script type="text/javascript" src="/2018/virtualdeck/scripts/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="/2018/virtualdeck/scripts/unauth.js"></script>
</footer>
</html>
