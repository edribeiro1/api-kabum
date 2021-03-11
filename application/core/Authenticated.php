<?php

namespace application\core;

use application\core\Api;
use application\models\Auth;


abstract class Authenticated extends Api 
{
    public function __construct()
    {
        parent::__construct();
        $tokenData = Auth::validate();
        $this->user_id = $tokenData['user_id'];
    }
}
