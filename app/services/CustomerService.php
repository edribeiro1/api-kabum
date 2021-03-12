<?php

namespace app\services;

use app\storage\CustomerStorage;

class CustomerService
{
    public function __construct() {
        $this->customerStorage = new CustomerStorage();
    }

    public function getAllCustomer()
    {
        return $this->customerStorage->getAllCustomer();
    }

    public function getCustomerById($id)
    {
        return $this->customerStorage->getCustomerById($id);
    }
}
