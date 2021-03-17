<?php

use app\services\CustomerService;
use app\interfaces\IController;
use app\dto\ListDTO;
use app\entities\Customer as CustomerEntities;

class Customer implements IController
{

    public function __construct()
    {
        $this->customerService = new CustomerService();
    }

    public function index($id = null)
    {

        switch (method()) {
            case 'GET':
                $this->getMethod($id);
                break;

            case 'POST':
                $this->postMethod();
                break;

            case 'PUT':
                $this->putMethod($id);
                break;

            case 'DELETE':
                $this->deleteMethod($id);
                break;

            default:
                send(400, 'Method not implemented');
                break;
        }
    }

    private function getMethod($id)
    {
        if (validateStrictlyPositiveNumber($id)) {
            try {
                $data = $this->customerService->getCustomerById($id);
                send(200, 'Success', $data);
            } catch (Exception $e) {
                send($e->getCode(), $e->getMessage());
            }
        } else {
            try {
                $params = getContents();
                $data = $this->customerService->getCustomerList(new ListDTO($params));
                send(200, 'Success', $data);
            } catch (Exception $e) {
                send($e->getCode(), $e->getMessage());
            }
        }
    }

    private function postMethod()
    {
        try {
            $params = getContents();

            $customer = new CustomerEntities(
                $params['name'] ?? null,
                $params['birthDate'] ?? null,
                $params['cpf'] ?? null,
                $params['rg'] ?? null,
                $params['phoneNumber'] ?? null,
                $params['address'] ?? []
            );

            $this->customerService->upsertCustomer($customer);
            send(200, 'Registered successfully');
        } catch (Exception $e) {
            send($e->getCode(), $e->getMessage());
        }
    }

    private function putMethod($id)
    {

        if (!validateStrictlyPositiveNumber($id)) {
            send(400, 'It is not possible to update without an "id"');
        }

        try {
            $params = getContents();

            $customer = new CustomerEntities(
                $params['name'] ?? null,
                $params['birthDate'] ?? null,
                $params['cpf'] ?? null,
                $params['rg'] ?? null,
                $params['phoneNumber'] ?? null,
                $params['address'] ?? [],
                $id
            );

            $this->customerService->upsertCustomer($customer);
            send(200, 'Successfully updated');
        } catch (Exception $e) {
            send($e->getCode(), $e->getMessage());
        }
    }

    private function deleteMethod($id)
    {

        if (!validateStrictlyPositiveNumber($id)) {
            send(400, 'It is not possible to delete without an "id"');
        }

        try {
            $status = $this->customerService->deleteCustomer((int)$id);

            if ($status) {
                send(200, 'Successfully deleted');
            } else {
                send(400, 'It was not possible to delete this customer');
            }
        } catch (Exception $e) {
            send($e->getCode(), $e->getMessage());
        }
    }
}
