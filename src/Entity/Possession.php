<?php

namespace Entity;

class Possession
{
    private $id;
    private $game;
    private $user;

    public function __construct()
    {
        $this->id = -1;
    }

    static public function createFromJson($json)
    {
        $possession = new self();
        $possession->id = $json["id"];
        $possession->game = $json["game"];
        $possession->user = $json["user"];

        return $possession;
    }

    public function toJson()
    {
        return [
            "id" => $this->id,
            "game" => $this->game,
            "user" => $this->user
        ];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getGame()
    {
        return $this->game;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setGame($gameId)
    {
        $this->game = $gameId;
    }

    public function setUser($userId)
    {
        $this->user = $userId;
    }
}
