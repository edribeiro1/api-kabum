<?php

use application\models\Auth as Model;

class Auth
{
  
    public function index()
    {
        if (method() == 'POST') {
            $params = getContents();
            if (isset($params['username']) && isset($params['password'])) {
                $data = Model::token($params);

                if ($data) {
                    send(200, true, 'Token successfully generated', $data);
                }

                send(400, false, 'Error generate token');
            }
            send(400, false, 'Invalid params');
        }

        send(400, false, 'Invalid method: '. method());
    }
}
