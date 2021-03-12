<?php

namespace app\middlewares;

use app\services\AuthService;

class Authentication 
{
    public static function authenticate()
    {
        $tokenData = AuthService::validate();
        // $this->user_id = $tokenData['user_id'];
        return $tokenData;
    }
}
