<?php

namespace Model;

use Entity\User;

class Security
{
    private $database;
    private $lastError;

    public function __construct()
    {
        $this->database = new Database();
        $this->lastError = "";
    }

    public static function getDataGET($key)
    {
        return self::getData($key, true);
    }

    public static function getDataPOST($key)
    {
        return self::getData($key, false);
    }

    public static function getData($key, $isGET)
    {
        if ($isGET) {
            $data = isset($_GET[$key]) ? htmlspecialchars($_GET[$key]) : null;
        } else {
            $data = isset($_POST[$key]) ? htmlspecialchars($_POST[$key]) : null;
        }
        return $data;
    }

    public function isAuthenticated()
    {
        return isset($_SESSION["auth"]);
    }

    public function authenticate($email, $password)
    {
        if ($email === null || $password === null) {
            return false;
        }

        $email = htmlspecialchars($email);
        $password = md5(htmlspecialchars($password));

        if ($this->database->connect() === false) {
            $this->lastError = "Impossible de se connecter à la base de données";
            return false;
        }

        $user = $this->database->getUser($email, $password);
        if ($user === false) {
            $this->lastError = "Impossible de vous authentifier";
            return false;
        }

        $_SESSION["auth"] = $user->toJson();
        return true;
    }

    public function logout()
    {
        unset($_SESSION["auth"]);
    }

    public function getCurrentUser()
    {
        if ($this->isAuthenticated()) {
            return User::createFromJson($_SESSION["auth"]);
        }

        return null;
    }

    public function getLastError()
    {
        return $this->lastError;
    }

    public function signNewUser()
    {
        $username = self::getDataPOST("username");
        $email = self::getDataPOST("email");
        $password = self::getDataPOST("password");
        $password2 = self::getDataPOST("password2");
        $firstname = self::getDataPOST("firstname");
        $lastname = self::getDataPOST("lastname");
        $address = self::getDataPOST("address");
        $city = self::getDataPOST("city");
        $postal = self::getDataPOST("postal");
        $phone = self::getDataPOST("phone");

        if ($username === null || empty($username)) {
            $this->lastError = "Vous devez entrer un pseudonyme";
            return false;
        }

        if ($this->isValidEmail($email) === false) {
            $this->lastError = "Vous devez entrer un email valide";
            return false;
        }

        if ($this->isValidPassword($password) === false) {
            $this->lastError = "Vous devez entrer un mot de passe valide";
            return false;
        }

        if ($password !== $password2) {
            $this->lastError = "Veuillez re-confirmer le mot de passe";
            return false;
        }

        if ($this->database->connect() === false) {
            $this->lastError = "Impossible de se connecter à la base de données";
            return false;
        }

        if ($this->database->getUser($email) !== false) {
            $this->lastError = "Un compte avec cet email existe déjà";
            return false;
        }

        $user = new User();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword(md5($password));
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setAddress($address);
        $user->setCity($city);
        $user->setPostal($postal);
        $user->setPhone($phone);

        $this->database->addUser($user);

        return true;
    }

    public function updateUser($user)
    {
        $holoLensIpAddress = self::getDataPOST("holoLensIpAddress");
        $username = self::getDataPOST("username");
        $email = self::getDataPOST("email");
        $passwordOld = self::getDataPOST("passwordold");
        $password = self::getDataPOST("password");
        $password2 = self::getDataPOST("password2");
        $firstname = self::getDataPOST("firstname");
        $lastname = self::getDataPOST("lastname");
        $address = self::getDataPOST("address");
        $city = self::getDataPOST("city");
        $postal = self::getDataPOST("postal");
        $phone = self::getDataPOST("phone");

        if ($username === null || empty($username)) {
            $this->lastError = "Vous devez entrer un pseudonyme";
            return false;
        }

        if ($this->isValidEmail($email) === false) {
            $this->lastError = "Vous devez entrer un email valide";
            return false;
        }

        if ($password !== null && empty($password) === false) {
            if ($user->getPassword() !== md5($passwordOld)) {
                $this->lastError = "Ce n'est pas le bon mot de passe";
                return false;
            }

            if ($this->isValidPassword($password) === false) {
                $this->lastError = "Vous devez entrer un mot de passe valide";
                return false;
            }

            if ($password !== $password2) {
                $this->lastError = "Veuillez re-confirmer le mot de passe";
                return false;
            }
        }

        if ($this->database->connect() === false) {
            $this->lastError = "Impossible de se connecter à la base de données";
            return false;
        }

        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword(md5($password));
        $user->setHoloLensIpAddress($holoLensIpAddress);
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setAddress($address);
        $user->setCity($city);
        $user->setPostal($postal);
        $user->setPhone($phone);
        $this->database->updateUser($user);
        $_SESSION["auth"] = $user->toJson();
        return true;
    }

    public function isValidEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function isValidPassword($password)
    {
        $result = preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/', $password);
        return $result !== 0 && $result !== false;
    }
}
