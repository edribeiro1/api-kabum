<?php 

namespace app\services;

use app\storage\UserStorage;
use app\entities\User;

class UserService
{

    private static $authenticatedUser;

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

    public static function setAuthenticatedUser(User $user)
    {
        self::$authenticatedUser = $user;
    }

    public static function authenticatedUser()
    {
        return self::$authenticatedUser;
    }

}