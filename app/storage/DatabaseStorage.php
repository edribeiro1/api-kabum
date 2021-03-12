<?php

namespace app\storage;

use app\providers\Database;

abstract class DatabaseStorage{

    //static instance to not instantiate new bank connections when it is necessary to use the database
    protected static $dbInstance = null;

    function __construct() {
        if (!self::$dbInstance) {
            self::$dbInstance = new Database();
        }
        $this->db = self::$dbInstance;
    }
}