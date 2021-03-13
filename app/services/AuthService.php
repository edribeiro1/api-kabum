<?php

namespace app\services;

use Exception;

class AuthService
{
    private static $header = ['typ' => 'JWT', 'alg' => 'HS256'];
    private static $tokenLifetime = 43200; //12 hours

    public static function generateToken($params = [])
    {

        $userService = new UserService();
        $user = $userService->getUserByUsername($params['username']);

        if (!$user) {
            throw new Exception('User not found', 401);
        }

        if ($user->password == md5($params['password'])) {
            $expire = time() + self::$tokenLifetime;
            $token = self::generateHashToken($user->id, $user->name, $expire);
            return ['token' => $token, 'expire' => $expire];
        }

        throw new Exception('Could not verify', 401);
    }

    private static function generateHashToken($id, $name, $expire)
    {
        $payload = [
            'user_id' => $id,
            'name' => $name,
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
            throw new Exception('Missing authorization parameter in the header', 401);
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
                throw new Exception('Token has expired', 401);
            }

            if ($signatureProvided === $signature) {
                return $payload;
            }

            throw new Exception('Token is not valid', 401);
        }

        throw new Exception('Expected bearer token', 401);
    }
}
