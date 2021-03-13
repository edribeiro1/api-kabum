<?php

namespace app\entities;

class Customer
{
    public $id = null;
    public $name;
    public $birthDate;
    public $cpf;
    public $rg;
    public $phoneNumber;

    public function __construct($name = "", $birthDate = "", $cpf = "", $rg = "", $phoneNumber = "", $id = null)
    {
        $this->name = $name;
        $this->birthDate = $birthDate;
        $this->cpf = $cpf;
        $this->rg = $rg;
        $this->phoneNumber = $phoneNumber;

        if ($id && is_numeric($id)) {
            $this->id = $id;
        }
    }
}
