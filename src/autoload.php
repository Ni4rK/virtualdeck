<?php

session_start();

require_once 'Controller/Home.php';
require_once 'Controller/Games.php';
require_once 'Controller/Profile.php';

require_once 'Model/Database.php';
require_once 'Model/Security.php';

require_once 'View/Response.php';

require_once 'Entity/User.php';
require_once 'Entity/Game.php';
require_once 'Entity/Possession.php';
