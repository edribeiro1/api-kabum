<?php

use app\services\CustomerService;
use app\interfaces\IController;

class Customer implements IController
{

    public function index($id=false)
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
                send(400, false, 'Method not implemented'); 
                break;
        }
    }

    private function getMethod($id)
    {
        $customerService = new CustomerService();
        
        if ($id && is_numeric($id)) {
            $data = $customerService->getCustomerById($id);
            if ($data) {
                send(200, true, 'Success', $data);
            }
            send(400, false, 'Customer not found');
        } else {
            $data = $customerService->getAllCustomer();
            if ($data) {
                send(200, true, 'Success', $data);
            }
            send(400, false, 'Customers not found');
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
