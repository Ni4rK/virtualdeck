<?php

require_once 'src/autoload.php';

$security = new \Model\Security();
if ($security->isAuthenticated()) {
    header('Location: http://virtualdeck.local.com/auth/home.php');
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Virtual Deck</title>
    <link rel="stylesheet" href="http://virtualdeck.local.com/stylesheets/unauth.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/x-icon" href="http://virtualdeck.local.com/images/favicon.ico" />
</head>

<body>
<div id="page" class="page">
    <div id="logo" class="icon"></div>
    <div id="corpse">
        <div id="text">
            <div class="text">
                <span id="title">The</span> plateform
            </div>
            <div class="text"> dedicated to games in augmented reality</div>
            <div id="videos">
                <video id="game1" class="video"><source src="http://virtualdeck.local.com/videos/Solitaire.mp4" type="video/mp4"></video>
                <video id="game3" class="hidden video"><source src="http://virtualdeck.local.com/videos/SeemsCity.mp4" type="video/mp4"></video>
                <video id="game4" class="hidden video"><source src="http://virtualdeck.local.com/videos/Strategy.mp4" type="video/mp4"></video>
            </div>
        </div>
        <input type="button" id="connect" class="button" value="Sign in"/>
        <div id="login_form" class="hidden">
            <input id="email" type="email" class="field" placeholder="Email"/>
            <input id="password" type="password" class="field" placeholder="Password"/>
            <input id="log_in" type="text" class="field button" value="Log in"/>
        </div>
        <input type="button" id="error" class="button hidden" value="Error"/>
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
        <div class="sign_label">Account information</div>
        <div><label for="sign_username">Username</label><input id="sign_username" type="text" class="field"/></div>
        <div><label for="sign_email">Email</label><input id="sign_email" type="email" class="field"/></div>
        <div><label for="sign_password">Password</label><input id="sign_password" type="password" class="field"/></div>
        <div><label for="sign_password2">Confirm the password</label><input id="sign_password2" type="password" class="field"/></div>
    </div>
    <div id="sign_billing">
        <div class="sign_label">Billing information</div>
        <div><label for="sign_firstname">Firstname</label><input id="sign_firstname" type="text" class="field"/></div>
        <div><label for="sign_lastname">Lastname</label><input id="sign_lastname" type="text" class="field"/></div>
        <div><label for="sign_address">Adress</label><input id="sign_address" type="text" class="field"/></div>
        <div><label for="sign_city">City</label><input id="sign_city" type="text" class="field"/></div>
        <div><label for="sign_postal">Postal code</label><input id="sign_postal" type="text" class="field"/></div>
        <div><label for="sign_phone">Phone</label><input id="sign_phone" type="text" class="field"/></div>
    </div>
    <input type="button" id="sign" class="button" value="Sign up and Log in"/>
</div>
</body>

<footer>
    <script type="text/javascript" src="http://virtualdeck.local.com/scripts/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="http://virtualdeck.local.com/scripts/unauth.js"></script>
</footer>
</html>
