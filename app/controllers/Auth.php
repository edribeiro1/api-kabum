<?php

use app\services\AuthService;

class Auth
{
    public function index()
    {
        if (!method() == 'POST') {
            send(400, 'Invalid method: ' . method());
        }

        $params = getContents();
        if (!isset($params['username']) || !isset($params['password'])) {
            send(400, 'Missing parameters: username, password');
        }

        try {
            $data = AuthService::generateToken($params);
            send(200, 'Token successfully generated', $data);
        } catch (Exception $e) {
            send($e->getCode(), $e->getMessage());
        }
    }
}
