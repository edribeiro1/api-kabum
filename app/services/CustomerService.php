<?php

namespace app\services;

use app\storage\CustomerStorage;
use app\dto\ListDTO;


class CustomerService
{

    public function __construct()
    {
        $this->customerStorage = new CustomerStorage();
    }

    public function list(ListDTO $params)
    {

        $customers = [];
        $total = $this->customerStorage->count($params);

        if ($total) {
            $customers = $this->customerStorage->list($params);
        }

        return [
            'total' => $total,
            'customers' => $customers
        ];

    }

    public function getCustomerById($id)
    {
        return $this->customerStorage->getCustomerById($id);
    }
}
