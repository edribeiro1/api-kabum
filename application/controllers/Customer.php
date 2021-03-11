<?php

use application\core\Authenticated;
use application\models\Customer as Model;
use application\interfaces\EntitiesController;

class Customer extends Authenticated implements EntitiesController
{
    function __construct() {
        parent::__construct();
        $this->model = new Model();
    }

    public function index($id=false)
    {
        var_dump($this->user_id);
        switch (method()) {
            case 'GET':
                break;
            
            default:
                send(400, false, 'Method not implemented');
                break;
        }
    }
}
