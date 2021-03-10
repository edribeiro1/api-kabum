<?php

use application\models\Auth as model;
use application\core\Api;


class Auth extends Api
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new model();
    }

    public function index()
    {
        var_dump("index");
    }

    public function metodo()
    {
        var_dump("metodo");
    }
}
