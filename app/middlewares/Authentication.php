<?php

namespace app\middlewares;

use app\services\AuthService;
use app\services\UserService;
use app\entities\User;
use Exception;

class Authentication
{
    public static function authenticate()
    {
        try {
            $tokenData = AuthService::validate();
        } catch (Exception $e) {
            send($e->getCode(), $e->getMessage());
        }

        $user = new User();
        $user->name = $tokenData['name'];
        $user->id = $tokenData['user_id'];

        UserService::setAuthenticatedUser($user);
    }
}
