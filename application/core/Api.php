<?php

namespace application\core;

use application\services\Database;

class Api
{
    public function __construct()
    {
        if (strtolower($_SERVER['REQUEST_METHOD']) == 'options') {
            Response::send();
        }

        $this->db = new Database();
    }
    
}
