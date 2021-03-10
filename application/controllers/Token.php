<?php

class Token extends Api_controller
{
    public function __construct()
    {
        parent::__construct();
        var_dump("Construtor");
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
