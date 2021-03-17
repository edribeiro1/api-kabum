<?php

namespace app\services;

use app\storage\CustomerStorage;
use app\storage\CustomerAddressStorage;
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

        $customerId = null;
        $customerAddressStorage = new CustomerAddressStorage();

        $customerAddresses = $customer->address;
        $customerStorageArray = $this->customerToStorageArray($customer);

        unset($customerStorageArray['address']);

        if (validateStrictlyPositiveNumber($customerStorageArray['id'])) {
            $customerId = $customerStorageArray['id'];
            $this->customerStorage->update($customerStorageArray);
            $customerAddressStorage->deleteAddressesByCustomerId($customerStorageArray['id']);
            
        } else {
            unset($customerStorageArray['id']);
            $customerId = $this->customerStorage->save($customerStorageArray);
        }

        if (is_array($customerAddresses) && count($customerAddresses) && validateStrictlyPositiveNumber($customerId)) {
            $customerAddressStorage->insert($customerAddresses, $customerId);
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
