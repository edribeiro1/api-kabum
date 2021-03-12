<?php

namespace app\models;

class Customer
{
    // private $table = 'customer';
    // private $id;
    // private $name;
    // private $birthDate;
    // private $cpf;
    // private $rg;
    // private $phoneNumber;
    // private $address;

    // public function __construct($name="", $birthDate="", $cpf="", $rg="", $phoneNumber="")
    // {
    //     parent::__construct();
    //     $this->name = $name;
    //     $this->birthDate = $birthDate;
    //     $this->cpf = $cpf;
    //     $this->rg = $rg;
    //     $this->phoneNumber = $phoneNumber;
    // }


    public function getAllCustomer()
    {
        $this->db->from($this->table);
        $total = $this->db->count();
        $rows = [];
        
        if ($total) {
            $this->db->from($this->table);
            $result = $this->db->get(true);

            if ($result) {
                $rows = $result;
            }
        }

        return ['total' => $total, 'rows' => $rows];
    }

    public function getCustomerById($id)
    {
        var_dump($this);
        // $this->db->where('id', $id);
        // $this->db->from($this->table);
        // $result = $this->db->get();

        // if ($result) {
        //     $customerAddress = new CustomerAddress();
        //     $addresses = $customerAddress->getAllAddressByCustomerId($id);
        //     $result['addresses'] = $addresses ? $addresses : [];
        // }

        // return $result;
    }
}
