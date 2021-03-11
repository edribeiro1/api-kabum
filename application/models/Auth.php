<?php

namespace application\models;

use application\core\Api;
use application\models\User;

class Auth extends Api
{
    private static $header = ['typ' => 'JWT', 'alg' => 'HS256'];
    private static $tokenLifetime = 43200; //12 hours

    public static function token($params=[])
    {
        $user = new User();
        $userData = $user->getUserByUsername($params['username']);

        if (!$userData) {
            send(401, false, 'User not found');
        }

        if ($userData['password'] == md5($params['password'])) {
            $expire = time() + self::$tokenLifetime;
            $token = self::generateHashToken($userData, $expire);
            return ['token'=> $token, 'expire' => $expire];
        }

        send(401, false, 'Could not verify');
    }

    private static function generateHashToken($userData, $expire)
    {
        $payload = [
            'user_id' => $userData['id'],
            'name' => $userData['name'],
            'exp' => $expire
        ];

        $header = json_encode(self::$header);
        $payload = json_encode($payload);

        $header = base64_encode($header);
        $payload = base64_encode($payload);

        $signature = hash_hmac('sha256', $header . "." . $payload, $_ENV['SECRET_KEY'], true);
        $signature = base64_encode($signature);

        return "$header.$payload.$signature";
    }

    public static function validate()
    {
        $headers = getallheaders();
        if (!isset($headers['authorization']) && !isset($headers['Authorization'])) {
            send(401, false, 'Authorization not found');
        }
        $authorizationToken = isset($headers['authorization']) ? $headers['authorization'] : $headers['Authorization'];

        $authorizationToken = explode(' ', $authorizationToken);
        if (is_array($authorizationToken) && count($authorizationToken) == 2 && $authorizationToken[0] == 'Bearer') {
            $token = $authorizationToken[1];

            $tokenParts = explode('.', $token);
            $header = base64_decode($tokenParts[0]);
            $payload = base64_decode($tokenParts[1]);
            $signatureProvided = $tokenParts[2];

            $headerBase64 = base64_encode($header);
            $payloadBase64 = base64_encode($payload);

            $signature = hash_hmac('sha256', $headerBase64 . "." . $payloadBase64, $_ENV['SECRET_KEY'], true);
            $signature = base64_encode($signature);


            $payload = json_decode($payload, true);
            $expiration = $payload['exp'];

            
            if (time() > $expiration) {
                send(401, false, 'Token has expired');
            }

            if ($signatureProvided === $signature) {
                return $payload;
            }

            send(401, false, 'Token is not valid');
        } else {
            send(401, false, 'Expected bearer token');
        }
    }
}
