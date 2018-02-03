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
                "error" => "You are not authentified. Please connect first to see this page"
            ]);
        }

        if ($this->database->connect() === false) {
            return $this->response->render("error.html.twig", [
                "error" => "Can't connect to database"
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

            $price = $bought ? "Owned" : ($game->getPrice() == 0 ? "Get if (free)" : "Get it (" . $game->getPrice() . " €)");
            $listContents .= $this->response->render("game.html.twig", [
                "name" => $game->getName(),
                "picture" => $game->getPicture(),
                "video" => $game->getVideo(),
                "description" => $game->getDescription(),
                "price" => $price,
                "link" => $game->getLink(),
                "buyable" => $bought ? "blocked" : "authorized",
                "downloadable" => $bought ? "authorized" : "blocked",
                "installable" => $bought ? "authorized" : "blocked"
            ], [], false);
        }

        return $this->response->render("games.html.twig", [
            "username" => $user->getUsername(),
            "listname" => $listOwned ? "My games" : "All games",
            "games" => $listContents,
            "showall" => $listOwned ? "" : "hidden"
        ]);
    }

    public function purchaseAction()
    {
        $data = [
            "success" => true,
			"stripped" => false
        ];

        if ($this->security->isAuthenticated() === false) {
            $data["success"] = false;
            $data["message"] = "You are not authentified. Please connect first to see this page";
            return $this->response->json($data);
        }

        if ($this->database->connect() === false) {
            $data["success"] = false;
            $data["message"] = "Can't connect to the database";
            return $this->response->json($data);
        }

        $user = $this->security->getCurrentUser();
		$gameName = Security::getDataPOST("game");
        if ($gameName === null || ($game = $this->database->getGame($gameName)) === false) {
            $data["success"] = false;
            $data["message"] = "This is not a valid game name";
            return $this->response->json($data);
        }

		$this->database->addPossession($user, $game);
        if ($game->getPrice() == 0) {
			$data["message"] = "Purchase successfully done !";
		} else {
			$data["stripped"] = true;
			$data["stripe"] = $this->response->render("stripe.html.twig", [
				"game" => $gameName,
				"price" => $game->getPrice(),
				"name" => !empty($user->getFirstname()) || !empty($user->getLastname()) ? $user->getFirstname() . " " . $user->getLastname() : "",
				"email" => $user->getEmail(),
				"phone" => $user->getPhone(),
				"address" => $user->getAddress(),
				"city" => $user->getCity(),
				"postal" => $user->getPostal()
			], [], false);
		}

		return $this->response->json($data);
    }

    public function downloadAction()
    {
        $data = [
            "success" => true
        ];

        if ($this->security->isAuthenticated() === false) {
            $data["success"] = false;
            $data["message"] = "You are not authentified. Please connect first to see this page";
            return $this->response->json($data);
        }

        if ($this->database->connect() === false) {
            $data["success"] = false;
            $data["message"] = "Can't connect to the database";
            return $this->response->json($data);
        }

        $user = $this->security->getCurrentUser();
        $gameName = Security::getDataPOST("game");
        if ($gameName === null || ($game = $this->database->getGame($gameName)) === false) {
            $data["success"] = false;
            $data["message"] = "This is not a valid game name";
            return $this->response->json($data);
        }

        if (($possession = $this->database->getPossession($user, $game)) === false) {
            $data["success"] = false;
            $data["message"] = "You didn't purchase this game yet";
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
            $data["message"] = "You are not authentified. Please connect first to see this page";
            return $this->response->json($data);
        }

        if ($this->database->connect() === false) {
            $data["success"] = false;
            $data["message"] = "Can't connect to the database";
            return $this->response->json($data);
        }

        $user = $this->security->getCurrentUser();
        $gameName = Security::getDataPOST("game");
        if ($gameName === null || ($game = $this->database->getGame($gameName)) === false) {
            $data["success"] = false;
            $data["message"] = "This is not a valid game name";
            return $this->response->json($data);
        }

        if (($possession = $this->database->getPossession($user, $game)) === false) {
            $data["success"] = false;
            $data["message"] = "You didn't purchase this game yet";
            return $this->response->json($data);
        }

        $data["link"] = sprintf(
        	"http://%s/AppManager.htm",
        	$user->getHoloLensIpAddress()
		);
        return $this->response->json($data);
    }
}
