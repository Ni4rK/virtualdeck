<?php

namespace Model;

use Entity\Game;
use Entity\Possession;
use Entity\User;

class Database
{
    private $db;

    private $driver;
    private $host;
    private $dbname;
    private $dbuser;
    private $dbpassword;

    public function __construct($config = [])
    {
        $this->driver = "mysql";
        $this->host = "den1.mysql6.gear.host";
        $this->dbname = "virtualdeck";
        $this->dbuser = "virtualdeck";
        $this->dbpassword = "Cz3P86-?leWH";

        foreach ($config as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public function connect()
    {
        try {
            $this->db = new \PDO(
                '' . $this->driver . ':' .
                'host=' . $this->host . ';' .
                'dbname=' . $this->dbname . ';' .
                'charset=utf8',
                '' . $this->dbuser,
                '' . $this->dbpassword
            );
        } catch(\Exception $e) {
            return false;
        }
        return true;
    }

    public function query($type, $what, $from, $where = '', $more = '')
    {
        $request = $this->db->prepare(
            '' . $type .
            ' ' . $what .
            ' FROM ' . $from .
            (empty($where) ? '' : ' WHERE ' . $where) .
            ' ' . $more
        );

        $request->execute();

        $results = [];
        while ($result = $request->fetch()) {
            $results[] = $result;
        }

        $request->closeCursor();

        return $results;
    }

    public function insert($type, $into, $data)
    {
        $keys = implode(', ', array_keys($data));
        $values = implode('\', \'', array_values($data));

        $this->db->exec(
            '' . $type .
            ' INTO ' . $into .
            ' (' . $keys . ')' .
            ' VALUES(\'' . $values . '\')'
        );
    }

    public function update($type, $table, $data, $where = '', $more = '')
    {
        $set = '';
        $length = count($data);
        $counter = 1;
        foreach ($data as $key => $value) {
            $set .= $key . ' = \'' . $value . '\'';
            $set = $counter < $length ? $set . ', ' : $set . ' ';
            $counter += 1;
        }

        $query = '' . $type . ' ' . $table . ' SET ' . $set;
        if (empty($where) === false) {
            $query .= ' WHERE ' . $where;
        }
        $query .= $more;

        $this->db->exec($query);
    }

    public function getUser($email, $password = null)
    {
        $where = 'email = \'' . $email . '\'';
        if ($password !== null) {
            $where .= ' AND password = \'' . $password . '\'';
        }

        $results = $this->query('SELECT', '*', 'user', $where);
        if (empty($results)) {
            return false;
        }
        $result = $results[0];

        $user = new User();
        $user->setId($result["id"]);
        $user->setUsername($result["username"]);
        $user->setEmail($result["email"]);
        $user->setPassword($result["password"]);
        $user->setHoloLensIpAddress($result["holoLens_ip_address"]);
        $user->setFirstname($result["firstname"]);
        $user->setLastname($result["lastname"]);
        $user->setAddress($result["address"]);
        $user->setCity($result["city"]);
        $user->setPostal($result["postal"]);
        $user->setPhone($result["phone"]);

        return $user;
    }

    public function addUser($user)
    {
        $this->insert('INSERT', 'user', [
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'holoLens_ip_address' => $user->getHoloLensIpAddress(),
            'firstname' => $user->getFirstname(),
            'lastname' => $user->getLastname(),
            'address' => $user->getAddress(),
            'city' => $user->getCity(),
            'postal' => $user->getPostal(),
            'phone' => $user->getPhone()
        ]);
    }

    public function updateUser($user)
    {
        $this->update('UPDATE', 'user', [
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'holoLens_ip_address' => $user->getHoloLensIpAddress(),
            'firstname' => $user->getFirstname(),
            'lastname' => $user->getLastname(),
            'address' => $user->getAddress(),
            'city' => $user->getCity(),
            'postal' => $user->getPostal(),
            'phone' => $user->getPhone()
        ], ' id = ' . $user->getId());

    }

    public function getGames($user)
    {
        $games = [];
        $possessions = [];

        $results = $this->query('SELECT', '*', 'game');
        foreach ($results as $result) {
            $game = new Game();
            $game->setId($result["id"]);
            $game->setName($result["name"]);
            $game->setPicture($result["picture"]);
            $game->setVideo($result["video"]);
            $game->setDescription($result["description"]);
            $game->setPrice($result["price"]);
            $game->setLink($result["link"]);
            $games[] = $game;
        }

        $results = $this->query('SELECT', '*', 'possession', 'user_id = ' . $user->getId());
        foreach ($results as $result) {
            $possession = new Possession();
            $possession->setId($result["id"]);
            $possession->setGame($result["game_id"]);
            $possession->setUser($result["user_id"]);
            $possessions[$result["game_id"]] = $possession;
        }

        return [$games, $possessions];
    }

    public function getGame($name)
    {
        $results = $this->query('SELECT', '*', 'game', 'name = \'' . $name . '\'');
        if (empty($results)) {
            return false;
        }
        $result = $results[0];

        $game = new Game();
        $game->setId($result["id"]);
        $game->setName($result["name"]);
        $game->setPicture($result["picture"]);
        $game->setVideo($result["video"]);
        $game->setDescription($result["description"]);
        $game->setPrice($result["price"]);
        $game->setLink($result["link"]);

        return $game;
    }

    public function getPossession($user, $game)
    {
        $results = $this->query(
            'SELECT',
            '*',
            'possession',
            'game_id = \'' . $game->getId() . '\' AND user_id = \'' . $user->getId() . '\''
        );
        if (empty($results)) {
            return false;
        }
        $result = $results[0];

        $possession = new Possession();
        $possession->setId($result["id"]);
        $possession->setGame($result["game_id"]);
        $possession->setUser($result["user_id"]);

        return $possession;
    }

    public function addPossession($user, $game)
    {
        $this->insert('INSERT', 'possession', [
            'game_id' => $game->getId(),
            'user_id' => $user->getId()
        ]);
    }
}
