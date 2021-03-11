<?php

namespace application\models;

use application\core\Api;

class User extends Api
{
    private $schema = 'user';
    private $id;
    private $username;
    private $password;
    private $name;

    function __construct($username="", $password="", $name="") {
        parent::__construct();
        // $this->$username = $username;
        // $this->$password = md5($password);
        // $this->$name = $name;
    }

    // public function getId()
    // {
    //     return $this->$id;
    // }

    // public function getUsername()
    // {
    //     return $this->$username;
    // }

    // public function setUsername($username)
    // {
    //     $this->$username = $username;
    // }

    // public function getName()
    // {
    //     return $this->$name;
    // }

    // public function setName($name)
    // {
    //     $this->$name = $name;
    // }

    // public function setPassword($password)
    // {
    //     $this->$password = md5($password);
    // }

    public function getUserByUsername($username="")
    {
        if (is_string($username)) {
            // $this->db->select('id, username, password');
            $this->db->where('username', $username);
            $this->db->from($this->schema);
            return $this->db->get();
        }
        return false;
    }

}
