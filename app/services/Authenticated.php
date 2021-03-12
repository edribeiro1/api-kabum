<?php

namespace app\core;

use app\core\Api;
use app\models\Auth;


abstract class Authenticated extends Api 
{
    public function __construct()
    {
        parent::__construct();
        $tokenData = Auth::validate();
        $this->user_id = $tokenData['user_id'];
    }
}
