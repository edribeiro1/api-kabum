<?php

namespace app\services;

use app\storage\CustomerStorage;
use app\entities\Customer;
use app\dto\ListDTO;

use Exception;

class CustomerService
{

    public function __construct()
    {
        $this->customerStorage = new CustomerStorage();
    }

    public function upsertCustomer(Customer $customer)
    {
        $customerStorageArray = $this->customerToStorageArray($customer);

        if (validateStrictlyPositiveNumber($customerStorageArray['id'])) {
            $this->customerStorage->update($customerStorageArray);
        } else {
            unset($customerStorageArray['id']);
            $this->customerStorage->save($customerStorageArray);
        }
    }

    public function getCustomerList(ListDTO $params)
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

    public function customerToStorageArray(Customer $customer)
    {
        if ($customer instanceof Customer) {
            $customerArray = (array)$customer;
            $customerStorageArray = [];

            foreach ($customerArray as $key => $value) {
                $customerStorageArray[camelCaseToSnakeCase($key)] = $value;
            }
            return $customerStorageArray;
        }

        throw new Exception('Instance customer is invalid', 500);
    }

    public function deleteCustomer(int $id)
    {
        return $this->customerStorage->delete($id);
    }
}
