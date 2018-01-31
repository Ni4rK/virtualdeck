<?php

namespace Controller;


use Model\Database;
use Model\Security;
use View\Response;

class Profile
{
    private $database;
    private $security;
    private $response;

    public function __construct()
    {
        $this->database = new Database();
        $this->security = new Security();
        $this->response = new Response();
    }

    public function showAction()
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

        $user = $this->security->getCurrentUser();

        return $this->response->render("profile.html.twig", [
            "username" => $user->getUsername(),
            "email" => $user->getEmail(),
            "holoLensIpAddress" => $user->getHoloLensIpAddress(),
            "firstname" => $user->getFirstname(),
            "lastname" => $user->getLastname(),
            "address" => $user->getAddress(),
            "city" => $user->getCity(),
            "postal" => $user->getPostal(),
            "phone" => $user->getPhone()
        ]);
    }

    public function updateAction()
    {
        $data = [
            "success" => true,
            "message" => "Les informations ont été mises à jour"
        ];

        if ($this->security->isAuthenticated() === false) {
            $data["success"] = false;
            $data["message"] = "Vous devez vous authentifier pour accéder à cette page";
            return $this->response->json($data);
        }

        if ($this->database->connect() === false) {
            $data["success"] = false;
            $data["message"] = "Impossible de se connecter à la base de données";
            return $this->response->json($data);
        }

        $user = $this->security->getCurrentUser();

        if ($this->security->updateUser($user) === false) {
            $data["success"] = false;
            $data["message"] = $this->security->getLastError();
            return $this->response->json($data);
        }

        return $this->response->json($data);
    }
}
