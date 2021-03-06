<?php

function send($statusCode=200, $message=false, $data=false)
{
    $statusTexts = array(
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
    );

    $params = [];
    if (is_array($data) || is_object($data)) {
        $params['data'] = $data;
    }
  
    if ($message) {
        $params["message"] = $message;
    }

    header("HTTP/1.1 $statusCode $statusTexts[$statusCode]");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); 
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: Content-Type, Origin, X-Requested-With, Accept, Authorization');
    header('Content-Type: application/json');

    if (count($params)) {
        echo json_encode($params, true);
    }
    die;
}
