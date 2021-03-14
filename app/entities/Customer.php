<?php

namespace app\entities;

use Exception;

class Customer
{
    public $id = null;
    public $name;
    public $birthDate = null;
    public $cpf = null;
    public $rg = null;
    public $phoneNumber = null;

    public function __construct($name="", $birthDate = null, $cpf = null, $rg = null, $phoneNumber = null, $id = null)
    {
        if (validateString($name)) {
            $this->name = $name;
        } else {
            if ($name) {
                throw new Exception("Parameter 'name' is string", 400);
            } else {
                throw new Exception("Parameter 'name' is required", 400);
            }
        }

        if (validateDate($birthDate)) {
            $this->birthDate = $birthDate;
        }

        if (validateString($cpf)) {
            $this->cpf = $cpf;
        }

        if (validateString($rg)) {
            $this->rg = $rg;
        }

        if (validateString($phoneNumber)) {
            $this->phoneNumber = $phoneNumber;
        }

        if (validateStrictlyPositiveNumber($id)) {
            $this->id = (int)$id;
        }
    }

}
