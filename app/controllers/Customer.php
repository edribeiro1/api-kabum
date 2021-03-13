<?php

use app\services\CustomerService;
use app\interfaces\IController;
use app\dto\ListDTO;

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
        if ($id && is_numeric($id)) {
            try {
                $data = $this->customerService->getCustomerById($id);
                send(200, 'Success', $data);
            } catch (Exception $e) {
                send($e->getCode(), $e->getMessage());
            }
        } else {
            try {
                $params = getContents();
                $data = $this->customerService->list(new ListDTO($params));
                send(200, 'Success', $data);
            } catch (Exception $e) {
                send($e->getCode(), $e->getMessage());
            }
        }
    }

    private function postMethod()
    {
    }

    private function putMethod($id)
    {
    }

    private function deleteMethod($id)
    {
    }
}
