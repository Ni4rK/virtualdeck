<?php

namespace Entity;

class User
{
    private $id;
    private $username;
    private $email;
    private $password;
    private $holoLensIpAddress;
    private $firstname;
    private $lastname;
    private $address;
    private $city;
    private $postal;
    private $phone;

    public function __construct()
    {
        $this->id = -1;
        $this->holoLensIpAddress = '';
    }

    static public function createFromJson($json)
    {
        $user = new self();
        $user->id = $json["id"];
        $user->username = $json["username"];
        $user->email = $json["email"];
        $user->password = $json["password"];
        $user->holoLensIpAddress = $json["holoLensIpAddress"];
        $user->firstname = $json["firstname"];
        $user->lastname = $json["lastname"];
        $user->address = $json["address"];
        $user->city = $json["city"];
        $user->postal = $json["postal"];
        $user->phone = $json["phone"];

        return $user;
    }

    public function toJson()
    {
        return [
            "id" => $this->id,
            "username" => $this->username,
            "email" => $this->email,
            "password" => $this->password,
            "holoLensIpAddress" => $this->holoLensIpAddress,
            "firstname" => $this->firstname,
            "lastname" => $this->lastname,
            "address" => $this->address,
            "city" => $this->city,
            "postal" => $this->postal,
            "phone" => $this->phone
        ];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getHoloLensIpAddress()
    {
        return $this->holoLensIpAddress;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getPostal()
    {
        return $this->postal;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setHoloLensIpAddress($holoLensIpAddress)
    {
        $this->holoLensIpAddress = $holoLensIpAddress;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function setPostal($postal)
    {
        $this->postal = $postal;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }
}
