<?php 

namespace app\services;

use app\storage\UserStorage;

class UserService
{

    function __construct() {
        $this->userStorage = new UserStorage();
    }
    
    public function getUserByUsername($username="")
    {
        if (is_string($username)) {
            return $this->userStorage->getUserByUsername($username);
        }
        return false;
    }
}