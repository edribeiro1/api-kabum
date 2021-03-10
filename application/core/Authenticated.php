<?php

class Authenticated extends Api
{
    public function __construct()
    {
        $this->db = new Database();
    }
}
