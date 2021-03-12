<?php

namespace app\controllers;
use app\models\Auth;

abstract class Authenticated 
{
    public function __construct()
    {
        $tokenData = Auth::validate();
        $this->user_id = $tokenData['user_id'];
    }
}
