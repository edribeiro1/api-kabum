<?php

namespace app\models;

class User
{
    public $id;
    public $username;
    public $password;
    public $name;

    public function __construct($username="", $password="", $name="")
    {
        $this->$username = $username;
        $this->$password = $password;
        $this->$name = $name;
    }
}