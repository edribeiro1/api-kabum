<?php

namespace app\entities;

class User
{
    public $id = null;
    public $username;
    public $password;
    public $name;

    public function __construct($username = "", $password = "", $name = "", $id = null)
    {
        $this->username = $username;
        $this->password = $password;
        $this->name = $name;

        if (validateStrictlyPositiveNumber($id)) {
            $this->id = (int)$id;
        }
    }
}
