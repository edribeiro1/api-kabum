<?php

namespace application\core;

use application\services\Database;
use application\helpers\Utils;
use application\helpers\Response;

abstract class Api {

    protected static $dbInstance = null;

    function __construct() {
        if (!self::$dbInstance) {
            self::$dbInstance = new Database();
        }
        $this->db = self::$dbInstance;
    }
}
