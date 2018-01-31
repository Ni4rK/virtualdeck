<?php

namespace Controller;

use Model\Database;
use Model\Security;
use View\Response;

class Games
{
    private $response;
    private $security;
    private $database;

    public function __construct()
    {
        $this->response = new Response();
        $this->security = new Security();
        $this->database = new Database();
    }

    public function listAction()
    {
        if ($this->security->isAuthenticated() === false) {
            return $this->response->render("error.html.twig", [
                "error" => "Vous devez vous authentifier pour accéder à cette page"
            ]);
        }

        if ($this->database->connect() === false) {
            return $this->response->render("error.html.twig", [
                "error" => "Impossible de se connecter à la base de données"
            ]);
        }

        $listContents = '';
        $listOwned = isset($_GET["filter"]) && $_GET["filter"] === "owned";
        $user = $this->security->getCurrentUser();
        list($games, $possessions) = $this->database->getGames($user);

        foreach ($games as $game) {
            $bought = array_key_exists($game->getId(), $possessions);

            if ($listOwned && $bought === false) {
                continue;
            }

            $listContents .= $this->response->render("game.html.twig", [
                "name" => $game->getName(),
                "picture" => $game->getPicture(),
                "video" => $game->getVideo(),
                "description" => $game->getDescription(),
                "price" => $game->getPrice(),
                "link" => $game->getLink(),
                "buyable" => $bought ? "blocked" : "authorized",
                "downloadable" => $bought ? "authorized" : "blocked",
                "installable" => $bought ? "authorized" : "blocked"
            ], [], false);
        }

        return $this->response->render("games.html.twig", [
            "username" => $user->getUsername(),
            "listname" => $listOwned ? "Mes jeux" : "Tous les jeux",
            "games" => $listContents,
            "showall" => $listOwned ? "" : "hidden"
        ]);
    }

    public function purchaseAction()
    {
        $data = [
            "success" => true
        ];

        if ($this->security->isAuthenticated() === false) {
            $data["success"] = false;
            $data["message"] = "Vous devez être authentifié pour accéder à cette page";
            return $this->response->json($data);
        }

        if ($this->database->connect() === false) {
            $data["success"] = false;
            $data["message"] = "Impossible de se connecter à la base de données";
            return $this->response->json($data);
        }

        $user = $this->security->getCurrentUser();
        $gameName = Security::getDataPOST("game");
        if ($gameName === null || ($game = $this->database->getGame($gameName)) === false) {
            $data["success"] = false;
            $data["message"] = "Vous devez saisir un nom de jeu valide";
            return $this->response->json($data);
        }

        $this->database->addPossession($user, $game);
        $data["message"] = "Achat effectué avec succès";
        return $this->response->json($data);
    }

    public function downloadAction()
    {
        $data = [
            "success" => true
        ];

        if ($this->security->isAuthenticated() === false) {
            $data["success"] = false;
            $data["message"] = "Vous devez être authentifié pour accéder à cette page";
            return $this->response->json($data);
        }

        if ($this->database->connect() === false) {
            $data["success"] = false;
            $data["message"] = "Impossible de se connecter à la base de données";
            return $this->response->json($data);
        }

        $user = $this->security->getCurrentUser();
        $gameName = Security::getDataPOST("game");
        if ($gameName === null || ($game = $this->database->getGame($gameName)) === false) {
            $data["success"] = false;
            $data["message"] = "Vous devez saisir un nom de jeu valide";
            return $this->response->json($data);
        }

        if (($possession = $this->database->getPossession($user, $game)) === false) {
            $data["success"] = false;
            $data["message"] = "Vous n'avez pas encore acheté ce jeu";
            return $this->response->json($data);
        }

        $data["link"] = $game->getLink();
        return $this->response->json($data);
    }

    public function installAction()
    {
        $data = [
            "success" => true
        ];

        if ($this->security->isAuthenticated() === false) {
            $data["success"] = false;
            $data["message"] = "Vous devez être authentifié pour accéder à cette page";
            return $this->response->json($data);
        }

        if ($this->database->connect() === false) {
            $data["success"] = false;
            $data["message"] = "Impossible de se connecter à la base de données";
            return $this->response->json($data);
        }

        $user = $this->security->getCurrentUser();
        $gameName = Security::getDataPOST("game");
        if ($gameName === null || ($game = $this->database->getGame($gameName)) === false) {
            $data["success"] = false;
            $data["message"] = "Vous devez saisir un nom de jeu valide";
            return $this->response->json($data);
        }

        if (($possession = $this->database->getPossession($user, $game)) === false) {
            $data["success"] = false;
            $data["message"] = "Vous n'avez pas encore acheté ce jeu";
            return $this->response->json($data);
        }

        $data["link"] = $user->getHoloLensIpAddress();
        return $this->response->json($data);
    }
}
