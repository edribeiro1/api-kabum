<?php

use app\services\AuthService;

class Auth
{
    public function index()
    {
        if (!method() == 'POST') {
            send(400, false, 'Invalid method: '. method());
        }

        $params = getContents();
        if (!isset($params['username']) || !isset($params['password'])) {
            send(400, false, 'Invalid params');
        }

        $data = AuthService::generateToken($params);

        if ($data) {
            send(200, true, 'Token successfully generated', $data);
        }

        send(400, false, 'Error generate token');
    }
}
