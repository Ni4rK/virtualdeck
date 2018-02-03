<?php

namespace Controller;

use Model\Security;
use View\Response;

class Home
{
    private $response;
    private $security;

    public function __construct()
    {
        $this->response = new Response();
        $this->security = new Security();
    }

    public function homeAction()
    {
        if ($this->security->isAuthenticated()) {
            $user = $this->security->getCurrentUser();
            return $this->response->render("home.html.twig", [
                "username" => $user->getUsername()
            ]);
        }

        return $this->response->render("error.html.twig", [
            "error" => "You are not authentified. Please connect first to see this page"
        ]);
    }

    public function checkAction()
    {
        $data = [
            "success" => true
        ];

        if ($this->security->isAuthenticated() === false) {
            $email = isset($_POST["email"]) ? $_POST["email"] : null;
            $password = isset($_POST["password"]) ? $_POST["password"] : null;

            if ($this->security->authenticate($email, $password) === false) {
                $data["success"] = false;
                $data["message"] = $this->security->getLastError();
            }
        }

        return $this->response->json($data);
    }

    public function signAction()
    {
        $data = [
            "success" => true
        ];

        if ($this->security->signNewUser() === false) {
            $data["success"] = false;
            $data["message"] = $this->security->getLastError();
        }

        $email = isset($_POST["email"]) ? $_POST["email"] : null;
        $password = isset($_POST["password"]) ? $_POST["password"] : null;

        if ($data["success"] === true && $this->security->authenticate($email, $password) === false) {
            $data["success"] = false;
            $data["message"] = $this->security->getLastError();
        }

        return $this->response->json($data);
    }

    public function logoutAction()
    {
        $this->security->logout();
        header('Location: /');
        exit;
    }
}
