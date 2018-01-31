<?php

namespace Entity;

class Game
{
    private $id;
    private $name;
    private $picture;
    private $video;
    private $description;
    private $price;
    private $link;

    public function __construct()
    {
        $this->id = -1;
    }

    static public function createFromJson($json)
    {
        $user = new self();
        $user->id = $json["id"];
        $user->name = $json["name"];
        $user->picture = $json["picture"];
        $user->video = $json["video"];
        $user->description = $json["description"];
        $user->price = $json["price"];
        $user->link = $json["link"];

        return $user;
    }

    public function toJson()
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "picture" => $this->picture,
            "video" => $this->video,
            "description" => $this->description,
            "price" => $this->price,
            "link" => $this->link
        ];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPicture()
    {
        return $this->picture;
    }

    public function getVideo()
    {
        return $this->video;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getLink()
    {
        return $this->link;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    public function setVideo($video)
    {
        $this->video = $video;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function setLink($link)
    {
        $this->link = $link;
    }
}
